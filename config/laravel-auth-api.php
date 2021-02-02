<?php
// Laravel Auth API

return [

    // Auth methods
    'pipes' => [
        \GarbuzIvan\LaravelAuthApi\Pipes\SmsAuth::class,
        \GarbuzIvan\LaravelAuthApi\Pipes\EmailAuth::class,
        \GarbuzIvan\LaravelAuthApi\Pipes\DefaultAuth::class,
    ],

    // Create new token if api token exists in user
    'new_token_after_auth' => true,

    // Length token
    'length_token' => 80,

    // Email generator code
    'code_email' => [
        'charset'   =>  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        'length'    =>  4,
    ],

    // Template Mail
    'view_mail'  => 'gi_laravel_auth_api::Mail',

];
