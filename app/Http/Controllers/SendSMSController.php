<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\ApiException;
use GuzzleHttp\Client;

class SendSMSController extends Controller
{
    public function sendSMS(Request $request) 
    {
        try {
            // Log the incoming request
            \Log::info('SMS Request received:', $request->all());

            // Format the phone number
            $cleanNumber = ltrim(preg_replace('/[^0-9]/', '', $request->number), '0');
            $formattedNumber = '+63' . $cleanNumber;

            \Log::info('Sending to number:', ['formatted_number' => $formattedNumber]);

            // Prepare message text
            $messageText = '';
            if (!empty($request->applicant_name) && !empty($request->message)) {
                $messageText = $request->message . "\nName: " . ucfirst($request->applicant_name);
            } elseif (!empty($request->message)) {
                $messageText = $request->message;
            } elseif (!empty($request->applicant_name)) {
                $messageText = ucfirst($request->applicant_name);
            }

            // Try direct HTTP request to InfoBip API
            $client = new Client();
            
            $response = $client->post('https://g95v1j.api.infobip.com/sms/2/text/advanced', [
                'headers' => [
                    'Authorization' => 'App 79a999d476896f81b7dec8b37a362a21-831fe1fe-e40d-4229-a6be-5fa27adb59bb',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'messages' => [
                        [
                            'from' => 'InfoSMS',
                            'destinations' => [
                                ['to' => $formattedNumber]
                            ],
                            'text' => $messageText,
                            'notifyUrl' => config('app.url') . '/api/sms-callback',
                            'notifyContentType' => 'application/json',
                            'callbackData' => 'DLR callback data'
                        ]
                    ]
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);
            
            \Log::info('Direct API Response:', $responseBody);

            // Check if message was actually accepted
            if (!isset($responseBody['messages']) || empty($responseBody['messages'])) {
                throw new \Exception('No message confirmation received from InfoBip');
            }

            $messageStatus = $responseBody['messages'][0]['status'];
            \Log::info('Message Status:', $messageStatus);

            if ($messageStatus['groupId'] != 1) {
                throw new \Exception('Message not accepted: ' . ($messageStatus['description'] ?? 'Unknown error'));
            }

            if ($this->isAjax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'SMS sent successfully',
                    'messageId' => $responseBody['messages'][0]['messageId'] ?? null
                ]);
            }

            return redirect()->back()->with('success', 'SMS sent successfully!');

        } catch (\Exception $e) {
            \Log::error('SMS Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($this->isAjax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send SMS: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('fail', 'Failed to send SMS: ' . $e->getMessage());
        }
    }

    private function isAjax() {
        return request()->ajax() || request()->wantsJson();
    }
}

// host: 'g95v1j.api.infobip.com', //'v3l35p.api.infobip.com'
//             apiKey: //'4f9fd50598692fd38e636ea2b3327ca0-27a44da8-0bfb-4993-9fcb-4e7802270929'
//             '79a999d476896f81b7dec8b37a362a21-831fe1fe-e40d-4229-a6be-5fa27adb59bb'