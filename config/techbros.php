<?php
return [
    'author' => [
        'name' => 'Sharfuddin Shawon',
        'email' => 'sharf@shawon.xyz',
        'phone' => '01612404200',
        'url' => 'https://shawon.xyz',
        'facebook' => 'https://fb.me/sharf.shawon',
        'messenger' => 'https://m.me/sharf.shawon',
    ],
    'company' => [
        'name' => 'TechBros',
        'email' => 'info@techbros.com.bd',
        'phone' => '01612404200',
        'url' => 'https://www.techbros.com.bd',
        'facebook' => 'https://fb.me/TechBros.Bangladesh',
        'messenger' => 'https://m.me/TechBros.Bangladesh',
    ],
    'support' => [
        'name' => 'TechBros',
        'email' => 'support@techbros.app',
        'phone' => '01612404200',
        'url' => 'https://support.techbros.app',
        'facebook' => 'https://fb.me/TechBros.Bangladesh',
        'messenger' => 'https://m.me/TechBros.Bangladesh',
    ],
    'docs' => [
        'name' => 'Documentation',
        'url' => 'https://wiki.techbros.app/index.php?title='.config('app.name'),
    ],
    'recaptcha' => env('RECAPTCHA_ENABLED', false),
    'sms' => [
        'domain' => env('SMS_DOMAIN', false),
        'userid' => env('SMS_USER', false),
        'password' => env('SMS_PASSWORD', false),
        'sender' => env('SMS_SENDER', false),
    ],

    'socialite' => [
        'active' => env("SOCIALITE_ACTIVE", false),
        'services' => [
            'facebook' => '',
            'google' => '#dd4b39',
        ],
    ],
];
