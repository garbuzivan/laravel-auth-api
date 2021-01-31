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
     * Create new token if api token exists in user
     *
     * @var bool
     */
    protected bool $newToken = true;

    /**
     * Length token
     *
     * @var int
     */
    protected int $lengthToken = 80;

    /**
     * Email generator code - charsets
     *
     * @var array
     */
    protected array $generatorCodeCharsets = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

    /**
     * Email generator code - length
     *
     * @var int
     */
    protected int $generatorCodeLength = 4;

    /**
     * Configuration constructor.
     * @param Configuration|null $config
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
            if (get_parent_class($pipe) == AbstractPipes::class) {
                $this->pipes[] = $pipe;
            }
        }
    }

    /**
     * @param string $pipe
     */
    public function setPipe(string $pipe): void
    {
        if (get_parent_class($pipe) == AbstractPipes::class) {
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

    /**
     * @param bool $newToken
     */
    public function newTokenActive(bool $newToken): void
    {
        $this->newToken = $newToken;
    }

    /**
     * @return bool
     */
    public function isNewToken(): bool
    {
        return $this->newToken;
    }

    /**
     * @param int $length
     */
    public function setTokenLength(int $length): void
    {
        $this->lengthToken = $length;
    }

    /**
     * @return int
     */
    public function getTokenLength(): int
    {
        return $this->lengthToken;
    }

    /**
     * @param array $charsets
     */
    public function setGeneratorCodeCharsets(array $charsets): void
    {
        $this->generatorCodeCharsets = $charsets;
    }

    /**
     * @return array
     */
    public function getGeneratorCodeCharsets(): array
    {
        return $this->generatorCodeCharsets;
    }

    /**
     * @param int $length
     */
    public function setGeneratorCodeLength(int $length): void
    {
        $this->generatorCodeLength = $length;
    }

    /**
     * @return int
     */
    public function getGeneratorCodeLength(): int
    {
        return $this->generatorCodeLength;
    }

}
