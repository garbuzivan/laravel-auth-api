<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

use App\Models\User;
use GarbuzIvan\LaravelAuthApi\Contracts\PluginAuthFailInterface;
use GarbuzIvan\LaravelAuthApi\Contracts\PluginAuthInterface;
use GarbuzIvan\LaravelAuthApi\Contracts\PluginCreateUserInterface;
use Illuminate\Pipeline\Pipeline;

class Plugin
{
    /**
     * @var Configuration $config
     */
    protected Configuration $config;

    /**
     * Configuration constructor.
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @param User $user
     * @return User
     */
    public function createUser(User $user): User
    {
        $plugins = $this->config->getPlugins(PluginCreateUserInterface::class);
        app(Pipeline::class)
            ->send($user)
            ->via('handler')
            ->through($plugins)
            ->thenReturn();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function authSuccess(User $user): User
    {
        $plugins = $this->config->getPlugins(PluginAuthInterface::class);
        app(Pipeline::class)
            ->send($user)
            ->via('handler')
            ->through($plugins)
            ->thenReturn();
        return $user;
    }

    /**
     * @param AuthStatus $AuthStatus
     * @return AuthStatus
     */
    public function authFail(AuthStatus $AuthStatus): AuthStatus
    {
        $plugins = $this->config->getPlugins(PluginAuthFailInterface::class);
        app(Pipeline::class)
            ->send($AuthStatus)
            ->via('handler')
            ->through($plugins)
            ->thenReturn();
        return $AuthStatus;
    }
}
