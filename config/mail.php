<?php

return [


    'default' => config('constants.MAIL_MAILER'),

    'mailers' => [

        'smtp' => [
            'transport' => config('constants.MAIL_TRANSPORT'),
            // 'scheme' => env('MAIL_SCHEME'),
            // 'url' => env('MAIL_URL'),
            'encryption' => config('constants.MAIL_ENCRYPTION'),
            'host' => config('constants.MAIL_HOST'),
            'port' => config('constants.MAIL_PORT'),
            'username' => config('constants.MAIL_USERNAME'),
            'password' => config('constants.MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

      
    ],


    'from' => [
        'address' => config('constants.MAIL_FROM'),
        'name' => config('constants.MAIL_FORM_NAME'),
    ],

];
