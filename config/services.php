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

    'google_calendar' => [
        'api_key' => env('GOOGLE_CALENDAR_API_KEY'),
        'holiday_calendar_id_india' => 'en.indian.official#holiday@group.v.calendar.google.com',
        'holiday_calendar_id_india1' => 'en.islamic#holiday@group.v.calendar.google.com',
        'holiday_calendar_id_india2' => 'en.christian#holiday@group.v.calendar.google.com',
    ],

    'google' => [
        'api_key' => env('GOOGLE_API_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
