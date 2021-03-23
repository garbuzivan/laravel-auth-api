<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\User;

use App\Models\User;
use GarbuzIvan\LaravelAuthApi\Configuration;
use GarbuzIvan\LaravelAuthApi\Plugin;
use Illuminate\Support\Str;

class UserTransport
{
    /**
     * @param $value
     * @param string|null $field
     * @param Configuration $config
     * @return string|null
     */
    public function getUserOrCreate($value, string $field = null, Configuration $config): ?string
    {
        if (is_null($field)) {
            return null;
        }
        $user = User::where($field, $value)->first();
        if (!is_null($user)) {
            $user = (new Plugin($config))->authSuccess($user);
            return $this->getUserTokenAfterAuth($user, $config);
        }
        $token = Str::random($config->getTokenLength());
        $user = User::create([$field => $value, 'api_token' => $token]);
        $user = (new Plugin($config))->createUser($user);
        if (is_null($user->name) || mb_strlen(trim($user->name)) == 0) {
            User::where('id', $user->id)->update(['name' => 'ID' . $user->id]);
        }
        return $token;
    }

    /**
     * @param $user - Model User
     * @param Configuration $config
     * @return string|null
     */
    public function getUserTokenAfterAuth($user, Configuration $config): ?string
    {
        if (!$config->isNewToken() && !is_null($user->api_token)) {
            return $user->api_token;
        }
        $token = Str::random($config->getTokenLength());
        User::where('id', $user->id)->update(['api_token' => $token]);
        return $token;
    }
}
