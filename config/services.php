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
    'facebook' => [
        'client_id'        => '1245761342434336',
        'client_secret'    => '4bdcd742c2937d195f1c9b372665fb33',
        'redirect'         => 'https://www.souqkahraba.com/callback/facebook'
    ],

    'google' => [
        'client_id' => '242066880632-oqeqtr3hro4mcvkjv7lus5g7cgsqrfus.apps.googleusercontent.com',
        'client_secret' => 'T0vIv6CZyP303DNlc0aqebl4',
        'redirect' => 'https://www.souqkahraba.com/callback/google',
    ],
];
