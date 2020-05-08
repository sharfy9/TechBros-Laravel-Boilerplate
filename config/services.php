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
        'client_id' => "463459607752150",
        'client_secret' => "f4681221171592d82a2132778fd95f39",
        'redirect' => "http://localhost:8000/callback/facebook"
    ],

    'google' => [
        'client_id' => "953202959443-1d0srpl25vfsmom4gi964udutoc3q9m6.apps.googleusercontent.com",
        'client_secret' => "JzG2DqQHYwVkygjJnsn3CHbY",
        'redirect' => "http://localhost:8000/callback/google"
    ],
];
