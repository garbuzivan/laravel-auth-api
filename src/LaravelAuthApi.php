<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use GarbuzIvan\ImageManager\Configuration;
use GarbuzIvan\LaravelAuthApi\Models\AuthStatus;
use GarbuzIvan\LaravelAuthApi\Pipes\AbstractPipes;
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
    public function __construct(Configuration $config)
    {
        if (is_null($config)) {
            $config = new Configuration();
        }
        if ($config instanceof Configuration) {
            $this->config = $config;
        }
    }

    /**
     * The method takes an array of arguments and passes through the pipeline array of handlers
     *
     * @param array|null $auth
     * @return AuthStatus
     */
    public function auth(array $auth = null): AuthStatus
    {
        $AuthStatus = new AuthStatus($auth);
        return app(Pipeline::class)
            ->send($AuthStatus)
            ->via('handler')
            ->through($this->config->getPipes())
            ->thenReturn();
    }

}
