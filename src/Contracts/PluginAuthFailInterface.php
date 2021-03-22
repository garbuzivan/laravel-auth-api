<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Contracts;

use Closure;
use Illuminate\Http\Request;

interface PluginAuthFailInterface
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Request
     */
    public function handler(Request $request, Closure $next): Request;
}
