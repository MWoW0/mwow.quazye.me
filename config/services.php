<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'search_secret' => env('ALGOLIA_SEARCH_SECRET', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    'skyfire' => [
        // @deprecated Soap
        // 'location' => env('SF_SOAP_LOCATION', 'http://127.0.0.1:7878'),
        // 'uri' => env('SF_SOAP_URI', 'urn:TC'),
        // 'style' => env('SF_SOAP_STYLE', SOAP_RPC),

        // 'login' => env('SF_USER', 'admin'),
        // 'password' => env('SF_PASS', 'admin')
        'host' => 'game.quazye.me',
        'port' => 8085,

        'db_auth' => env('SF_DB_AUTH', 'skyfire_auth'),
        'db_characters' => env('SF_DB_CHARACTERS', 'skyfire_characters'),
        'db_world' => env('SF_DB_WORLD', 'skyfire_world')
    ],
];
