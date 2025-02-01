<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('google', function($app, $config) {
            try {
                $client = new Google_Client();
                
                // Set the application name
                $client->setApplicationName('Laravel Drive Integration');
                
                // Set access type to offline to get refresh token
                $client->setAccessType('offline');
                
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                
                // Refresh the access token
                $client->refreshToken($config['refreshToken']);
                
                // Get the access token
                $accessToken = $client->getAccessToken();
                
                // Debug output
                \Log::info('Google Client Configuration:', [
                    'has_client_id' => !empty($config['clientId']),
                    'has_client_secret' => !empty($config['clientSecret']),
                    'has_refresh_token' => !empty($config['refreshToken']),
                    'access_token' => $accessToken
                ]);
                
                $service = new Google_Service_Drive($client);
                $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);
                
                return new Filesystem($adapter);
            } catch (\Exception $e) {
                \Log::error('Google Drive Error: ' . $e->getMessage());
                throw $e;
            }
        });
    }
}