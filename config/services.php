<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'google' => [
    'client_id' => env('GOOGLE_DRIVE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
    'refresh_token' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
    'redirect' => env('APP_URL') . '/google-auth/callback',

    'toda_application_folder' => env('GOOGLE_TODA_APPLICATION_FOLDER'),
    'poda_application_folder' => env('GOOGLE_PODA_APPLICATION_FOLDER'),
    'private_service_folder' => env('GOOGLE_PRIVATE_SERVICE_FOLDER'),
    'sticker_application_folder' => env('GOOGLE_STICKER_APPLICATION_FOLDER'),
    'toda_dropping_folder' => env('GOOGLE_TODA_DROPPING_FOLDER'),
    'poda_dropping_folder' => env('GOOGLE_PODA_DROPPING_FOLDER'),
    'support_ticket_folder' => env('GOOGLE_TICKET_ATTACHMENT_FOLDER'),

],

];
