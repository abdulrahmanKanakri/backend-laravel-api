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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'ny_times' => [
        'endpoint' => env('NEW_YORK_TIMES_ENDPOINT'),
        'api_key' => env('NEW_YORK_TIMES_API_KEY'),
        'media_url' => env('NEW_YORK_TIMES_MEDIA_BASE_URL'),
    ],

    'the_guardian' => [
        'endpoint' => env('THE_GUARDIAN_ENDPOINT'),
        'api_key' => env('THE_GUARDIAN_API_KEY'),
    ],

    'news_api' => [
        'endpoint' => env('NEWSAPI_ENDPOINT'),
        'api_key' => env('NEWSAPI_API_KEY'),
    ],
];
