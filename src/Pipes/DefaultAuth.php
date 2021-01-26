<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;

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
        return $auth;
    }
}
