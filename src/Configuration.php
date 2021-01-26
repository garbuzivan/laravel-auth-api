<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use GarbuzIvan\LaravelAuthApi\Pipes\AbstractPipes;

class Configuration
{
    /**
     * @var string
     */
    protected string $configFile = 'laravel-auth-api';

    /**
     * The array of class pipes.
     *
     * @var array
     */
    protected $pipes = [];


    /**
     * Configuration constructor.
     * @param \GarbuzIvan\ImageManager\Configuration|null $config
     */
    public function __construct(Configuration $config = null)
    {
        if (is_null($config)) {
            $this->load();
        }
    }

    /**
     * @return $this|Configuration
     */
    public function load(): Configuration
    {
        $this->setPipes(config($this->configFile . '.pipes'));
        return $this;
    }

    /**
     * @param array $pipes
     */
    public function setPipes(array $pipes): void
    {
        $this->pipes = [];
        foreach ($pipes as $pipe) {
            if ($pipe instanceof AbstractPipes) {
                $this->pipes[] = $pipe;
            }
        }
    }

    /**
     * @param string $pipe
     */
    public function setPipe(string $pipe): void
    {
        if ($pipe instanceof AbstractPipes) {
            $this->pipes[] = $pipe;
        }

    }

    /**
     * @return array
     */
    public function getPipes(): array
    {
        return $this->pipes;
    }
}
