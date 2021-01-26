<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use GarbuzIvan\ImageManager\Configuration;
use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;
use Illuminate\Pipeline\Pipeline;

class LaravelAuthApi
{
    /**
     * @var Configuration $config
     */
    protected $config;

    /**
     * Configuration constructor.
     * @param Configuration|null $config
     */
    public function __construct(Configuration $config = null)
    {
        if (is_null($config)) {
            $config = new Configuration();
        }
        $this->config = $config;
    }

    public function auth(array $auth = null): AuthStatus
    {
        $AuthStatus = new AuthStatus($auth);
        return app(Pipeline::class)
            ->send($AuthStatus)
            ->via('auth')
            ->through($this->config->getPipes())
            ->thenReturn();
    }

    public function newToken(array $auth = null): bool
    {

    }

    public function getToken(array $auth = null): bool
    {

    }
}
