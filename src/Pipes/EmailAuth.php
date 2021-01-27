<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;

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
        $arg = $auth->getArg();
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep2(AuthStatus $auth): AuthStatus
    {
        $arg = $auth->getArg();
        return $auth;
    }
}
