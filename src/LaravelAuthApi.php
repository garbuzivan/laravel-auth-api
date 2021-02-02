<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use Illuminate\Contracts\Pipeline\Pipeline;

class LaravelAuthApi
{
    /**
     * @var Configuration $config
     */
    protected Configuration $config;

    /**
     * Configuration constructor.
     * @param Configuration|null $config
     */
    public function __construct(?Configuration $config = null)
    {
        $this->config = $config ?? new Configuration();
    }

    /**
     * The method takes an array of arguments and passes through the pipeline array of handlers
     *
     * @param array|null $auth
     * @return AuthStatus
     */
    public function auth(array $auth = null): AuthStatus
    {
        $AuthStatus = new AuthStatus($auth, $this->config);
        return app(Pipeline::class)
            ->send($AuthStatus)
            ->via('handler')
            ->through($this->config->getPipes())
            ->thenReturn();
    }

}
