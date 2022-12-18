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
        'client_id' => '690344774435367',
        'client_secret' => 'ebc50d3fd1d2f7286e02d247e5751ef4',
        'redirect' => 'http://localhost:8000/callback',
    ],

    'google' => [
        'client_id' => '716438745047-ua94i3snt6s01i0ncn3u33j5h5rvu9rk.apps.googleusercontent.com',
        'client_secret' => '23zeZz1ya9syFMH4ggQM2e-p',
        'redirect' => 'http://localhost:8000/callback/google',
    ],

];
