<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\ImageManager\Models\CodeEmail;
use GarbuzIvan\LaravelAuthApi\AuthStatus;
use GarbuzIvan\LaravelAuthApi\Generator;
use Illuminate\Support\Str;
use Prozorov\DataVerification\Types\Address;

class EmailAuth extends AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return mixed
     */
    public function auth(AuthStatus $auth): AuthStatus
    {
        $auth = $this->authByEmailStep2($auth);
        $auth = $this->authByEmailStep1($auth);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep1(AuthStatus $auth): AuthStatus
    {
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        if (isset($arg['email']) && filter_var($arg['email'], FILTER_VALIDATE_EMAIL)) {
            $arg = $auth->getArg();
            $data = [
                'email' =>  $arg['email'],
                'code'  =>  Str::random(40),
                'pass' =>   Generator::code(),
            ];
            CodeEmail::created($data);
            $data['step'] = 'step2';
            $data['pass'] = false;
            // event email send
            $auth->setStatus($data);
        }
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep2(AuthStatus $auth): AuthStatus
    {
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        return $auth;
    }
}
