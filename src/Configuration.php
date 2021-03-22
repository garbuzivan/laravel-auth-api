<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use App\Admin\Controllers\TestClass;
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
    protected array $pipes = [];

    /**
     * The array of class pipes.
     *
     * @var array
     */
    protected array $plugins = [];

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
     * View mail
     *
     * @var string
     */
    protected string $viewMail = 'gi_laravel_auth_api::Mail';

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
        $pipes = config($this->configFile . '.pipes');
        if (is_array($pipes)) {
            $this->setPipes($pipes);
        }
        $plugins = config($this->configFile . '.plugins');
        if (is_array($plugins)) {
            $this->setPlugins($plugins);
        }
        $newTokenActive = config($this->configFile . '.new_token_after_auth');
        if (is_bool($newTokenActive)) {
            $this->newTokenActive($newTokenActive);
        }
        $lengthToken = config($this->configFile . '.length_token');
        if (is_int($lengthToken)) {
            $this->setTokenLength($lengthToken);
        }
        $generateCodeCharset = config($this->configFile . '.code_email.charset');
        if (is_array($generateCodeCharset)) {
            $this->setGeneratorCodeCharsets($generateCodeCharset);
        }
        $generateCodeLength = config($this->configFile . '.code_email.length');
        if (is_int($generateCodeLength)) {
            $this->setGeneratorCodeLength($generateCodeLength);
        }
        $viewMail = config($this->configFile . '.view_mail');
        if (!is_null($viewMail)) {
            $this->setViewMail($viewMail);
        }
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
     * @param array $plugins
     */
    public function setPlugins(array $plugins): void
    {
        $this->plugins = [];
        foreach ($plugins as $plugin) {
            $this->plugins[] = $plugin;
        }
    }

    /**
     * @param string $plugin
     */
    public function setPlugin(string $plugin): void
    {
        $this->plugins[] = $plugin;
    }

    /**
     * @param string|null $interface
     * @return array
     */
    public function getPlugins(string $interface = null): array
    {
        if (is_null($interface)) {
            return $this->plugins;
        }
        $list = [];
        foreach ($this->plugins as $plugin) {
            $interfaces = class_implements($plugin);
            if (isset($interfaces[$interface])) {
                $list[] = $plugin;
            }
        }
        return $list;
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

    public function setViewMail(string $view): void
    {
        $this->viewMail = $view;
    }

    public function getViewMail(): string
    {
        return $this->viewMail;
    }

}
