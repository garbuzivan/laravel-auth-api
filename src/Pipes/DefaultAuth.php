<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use Closure;
use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;

class DefaultAuth extends AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @param Closure $next
     * @return mixed
     */
    public function auth(AuthStatus $auth, Closure $next)
    {
        $arg = $auth->getArg();
        return $next($auth);
    }
}
