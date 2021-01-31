<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;
use GarbuzIvan\LaravelAuthApi\ExceptionCode;
use GarbuzIvan\LaravelAuthApi\User\UserTransport;
use Illuminate\Support\Facades\Auth;

class DefaultAuth extends AbstractPipes
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
        if (isset($arg['email']) && isset($arg['password'])) {
            if (Auth::attempt([
                'email' => $arg['email'],
                'password' => $arg['password']
            ])) {
                if (!isset(Auth::user()->api_token)) {
                    $auth->setError(ExceptionCode::$ERROR_DONT_CREATE_API_TOKIN_IN_DB);
                }
                $token = (new UserTransport)->getUserTokenAfterAuth(Auth::user(), $auth->config);
                $auth->setToken($token);
            } else {
                $auth->setError(ExceptionCode::$ERROR_FORBIDDEN_403);
            }
        }
        return $auth;
    }
}
