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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'envato' => [
        'client_id' => env('ENVATO_CLIENT_ID'),
        'client_secret' => env('ENVATO_CLIENT_SECRET'),
        'redirect' => env('ENVATO_REDIRECT_URI'),
        'base_api_url' => env('ENVATO_BASE_API_URL'),
        'api_version' => env('ENVATO_API_VERSION'),
        'api_url' => env('ENVATO_API_URL'),
    ],
];
