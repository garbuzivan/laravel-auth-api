<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Contracts;

use App\Models\User;
use Closure;

interface PluginCreateUserInterface
{
    /**
     * @param User $user
     * @param Closure $next
     * @return User
     */
    public function handler(User $user, Closure $next): User;
}
