<?php
// Laravel Auth API

return [

    'pipes' => [
        \GarbuzIvan\LaravelAuthApi\Pipes\SmsAuth::class,
        \GarbuzIvan\LaravelAuthApi\Pipes\EmailAuth::class,
        \GarbuzIvan\LaravelAuthApi\Pipes\DefaultAuth::class,
    ],

];
