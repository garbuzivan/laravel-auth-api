<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

class AuthStatus
{
    /**
     * Incoming arguments
     *
     * @var array
     */
    protected array $arg = [];

    /**
     * @var array|null
     */
    protected ?array $status = null;

    /**
     * Token code
     *
     * @var ?string
     */
    protected ?string $token = null;

    /**
     * Error
     *
     * @var ?string
     */
    protected ?string $error = null;

    /**
     * @var Configuration|null
     */
    public ?Configuration $config = null;

    /**
     * Configuration constructor.
     * @param array|null $auth
     * @param Configuration|null $config
     */
    public function __construct(array $auth = null, ?Configuration $config = null)
    {
        if (!is_null($auth)) {
            $this->setArg($auth);
        }
        if ($config instanceof Configuration) {
            $this->config = $config;
        } else {
            $this->config = new Configuration();
        }
    }

    /**
     * Set incoming arguments
     *
     * @param array|null $auth
     */
    public function setArg(array $auth = null): void
    {
        if (!is_null($auth)) {
            $this->arg = $auth;
        }
    }

    /**
     * Get incoming arguments
     *
     * @return array
     */
    public function getArg(): array
    {
        return $this->arg;
    }

    /**
     * isSuccess auth
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return is_null($this->getError());
    }

    /**
     * Get token code
     *
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Set token code
     *
     * @param string|null $string
     * @return void
     */
    public function setToken(string $string = null): void
    {
        $this->token = $string;
    }

    /**
     * Get error
     *
     * @return string
     */
    public function getError(): ?string
    {
        if (!is_null($this->error)) {
            return $this->error;
        } elseif (is_null($this->getToken()) && is_null($this->getStatus())) {
            return 'Unknown error. Token cannot be empty';
        } else {
            return null;
        }
    }

    /**
     * Set error info
     *
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @param array|null $status
     */
    public function setStatus(array $status = null): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getStatus(): ?array
    {
        return $this->status;
    }
}
