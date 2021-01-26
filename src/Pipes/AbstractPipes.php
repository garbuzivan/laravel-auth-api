<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use Closure;
use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;

abstract class AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @param Closure $next
     * @return mixed
     */
    abstract public function auth(AuthStatus $auth, Closure $next);
}
