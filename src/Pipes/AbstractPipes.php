<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use Closure;
use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;

abstract class AbstractPipes
{
    /**
     * @param AuthStatus $auth
     * @param Closure $next
     * @return mixed
     */
    abstract public function handler(AuthStatus $auth, Closure $next)
    {
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $next($auth);
        }
        // handler
        $auth = $this->auth($auth);
        return $next($auth);
    }

    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    abstract public function auth(AuthStatus $auth): AuthStatus;
}
