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

    'resend' => [
        'key' => env('RESEND_KEY'),
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
    'newsapi' => [
        'key' => env('NEWS_API_KEY'),
        'url' => env('NEWS_API_URL', 'https://newsapi.org/v2/top-headlines'),
    ],

    'guardian' => [
        'key' => env('GUARDIAN_API_KEY'),
        'url' => env('GUARDIAN_API_URL', 'https://content.guardianapis.com/search'),
    ],
    'bbc' => [
        'key' => env('BBC_API_KEY'),
        'url' => env('BBC_API_URL', 'http://feeds.bbci.co.uk/news/rss.xml'),
    ],
    

];
