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

];
