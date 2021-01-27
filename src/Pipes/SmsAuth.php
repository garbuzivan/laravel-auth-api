<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;

class SmsAuth extends AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return mixed
     */
    public function auth(AuthStatus $auth): AuthStatus
    {
        $auth = $this->authBySmsStep2($auth);
        $auth = $this->authBySmsStep1($auth);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authBySmsStep1(AuthStatus $auth): AuthStatus
    {
        $arg = $auth->getArg();
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authBySmsStep2(AuthStatus $auth): AuthStatus
    {
        $arg = $auth->getArg();
        return $auth;
    }
}
