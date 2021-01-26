<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Models;

class AuthStatus
{
    /**
     * Incoming arguments
     *
     * @var array
     */
    protected array $arg = [];

    /**
     * Auth Status
     *
     * @var array
     */
    protected array $status = [];

    /**
     * Configuration constructor.
     * @param array|null $auth
     */
    public function __construct(array $auth = null)
    {
        $this->setArg($auth);
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
}
