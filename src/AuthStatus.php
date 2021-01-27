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
     * Configuration constructor.
     * @param array|null $auth
     */
    public function __construct(array $auth = null)
    {
        if (!is_null($auth)) {
            $this->setArg($auth);
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
        return is_null($this->error) && !is_null($this->token);
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
        } elseif (is_null($this->token)) {
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
    public function getStatus(): array
    {
        return $this->status;
    }
}
