<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    private $client;
    private const SCOPES = [
        'https://www.googleapis.com/auth/drive.file',
    ];

    public function __construct()
    {
        $this->client = new Client();
        $this->configureClient();
    }

    private function configureClient()
    {
        try {
            $this->client->setClientId(config('services.google.client_id'));
            $this->client->setClientSecret(config('services.google.client_secret'));
            $this->client->setRedirectUri(config('app.url') . '/google-auth/callback');
            $this->client->setScopes(self::SCOPES);
            $this->client->setAccessType('offline');
            $this->client->setPrompt('consent');
            $this->client->setIncludeGrantedScopes(true); 
        } catch (\Exception $e) {
            Log::error('Google Client configuration failed: ' . $e->getMessage());
            throw new \Exception('Failed to configure Google client');
        }
    }

    public function redirect()
    {
        try {
            $state = Str::random(40);
            Session::put('google_auth_state', $state);
            
            $this->client->setState($state);
            $authUrl = $this->client->createAuthUrl();
            
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Google Auth redirect failed: ' . $e->getMessage());
            return redirect()->route('landing.index')->with('error', 'Failed to initiate Google authorization');
        }
    }

    public function callback(Request $request)
    {
        try {
            $savedState = Session::pull('google_auth_state');
            if (!$savedState || $savedState !== $request->state) {
                throw new \Exception('Invalid state parameter');
            }

            if (!$request->has('code')) {
                throw new \Exception('Authorization code not received');
            }
            $token = $this->client->fetchAccessTokenWithAuthCode($request->code);
            
            if (!isset($token['refresh_token'])) {
                throw new \Exception('Refresh token not received. User may need to revoke access and try again.');
            }
            $this->storeTokens($token);
            Log::info('Google Drive authorization successful for user');

            return view('google-auth.success', [
                'refresh_token' => $token['refresh_token'],
                'instructions' => $this->getSetupInstructions($token['refresh_token'])
            ]);

        } catch (\Exception $e) {
            Log::error('Google Auth callback failed: ' . $e->getMessage());
            return redirect()->route('landing.index')->with('error', 'Google authorization failed: ' . $e->getMessage());
        }
    }

    private function storeTokens(array $token)
    {
        // Store access token in cache with expiration
        if (isset($token['access_token'])) {
            $expiresIn = isset($token['expires_in']) ? (int)$token['expires_in'] : 3600;
            Cache::put('google_drive_access_token', $token['access_token'], $expiresIn - 300); // Buffer of 5 minutes
        }

        if (isset($token['refresh_token'])) {
            // Store in database or other permanent storage
            // Example: $user->update(['google_refresh_token' => $token['refresh_token']]);
        }
    }

    private function getSetupInstructions(string $refreshToken): string
    {
        return "
            1. Copy these values to your .env file:
            
            GOOGLE_DRIVE_REFRESH_TOKEN={$refreshToken}
            
            2. Make sure you have these other required values in your .env:
            GOOGLE_DRIVE_CLIENT_ID=" . config('services.google.client_id') . "
            GOOGLE_DRIVE_CLIENT_SECRET=" . config('services.google.client_secret') . "
            
            3. Set up your desired Google Drive folder IDs:
            GOOGLE_DRIVE_FOLDER_ID=your_folder_id
            
            4. Restart your application server after updating .env
        ";
    }

    public function revokeAccess()
    {
        try {
            if ($this->client->getAccessToken()) {
                $this->client->revokeToken();
                Cache::forget('google_drive_access_token');                
                return redirect()->route('landing.index')->with('success', 'Google Drive access revoked successfully');
            }
        } catch (\Exception $e) {
            Log::error('Failed to revoke Google access: ' . $e->getMessage());
            return redirect()->route('landing.index')->with('error', 'Failed to revoke Google access');
        }
    }
}
