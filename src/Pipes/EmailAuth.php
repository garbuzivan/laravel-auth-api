<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\Models\TgBotUser;
use GarbuzIvan\LaravelAuthApi\AuthStatus;
use GarbuzIvan\LaravelAuthApi\ExceptionCode;
use GarbuzIvan\LaravelAuthApi\Generator;
use GarbuzIvan\LaravelAuthApi\User\UserTransport;
use Illuminate\Support\Str;

class EmailAuth extends AbstractCommand
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return mixed
     */
    public function auth(AuthStatus $auth): AuthStatus
    {
        $arg = $auth->getArg();
        if(!isset($arg['password'])){
            $auth = $this->authByEmailStep2($auth);
            $auth = $this->authByEmailStep1($auth);
        }
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
                'pass' =>   Generator::code($auth->config),
                'use' =>   0,
            ];
            TgBotUser::create($data);
            $data['step'] = 'step2';
            $data['pass'] = false;
            unset($data['use']);
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
        if (isset($arg['email']) && isset($arg['code']) && isset($arg['pass'])) {
            $validCode = TgBotUser::where('email', $arg['email'])
                ->where('code', $arg['code'])
                ->where('pass', $arg['pass'])
                ->where('use', 0)
                ->first();
            if(is_null($validCode)){
                $auth->setError(ExceptionCode::$ERROR_FORBIDDEN_403);
            } else {
                TgBotUser::where('email', $arg['email'])->delete();
                $token = (new UserTransport)->getUserOrCreate($arg['email'], 'email', $auth->config);
                $auth->setToken($token);
            }
        }
        return $auth;
    }
}
