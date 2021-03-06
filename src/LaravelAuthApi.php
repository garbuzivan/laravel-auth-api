<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use Illuminate\Pipeline\Pipeline;

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
        app(Pipeline::class)
            ->send($AuthStatus)
            ->via('handler')
            ->through($this->config->getPipes())
            ->thenReturn();

        if (!$AuthStatus->isSuccess()) {
            $AuthStatus = (new Plugin($this->config))->authFail($AuthStatus);
        }

        return $AuthStatus;
    }

}
