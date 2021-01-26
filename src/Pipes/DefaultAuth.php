<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;

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
        $auth = $this->authByEmailStep2($auth);
        $auth = $this->authByEmailStep1($auth);
        $auth = $this->authByEmailAndPassword($auth);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailAndPassword(AuthStatus $auth): AuthStatus
    {
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep1(AuthStatus $auth): AuthStatus
    {
        $auth->setToken('123321');
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep2(AuthStatus $auth): AuthStatus
    {
        return $auth;
    }
}
