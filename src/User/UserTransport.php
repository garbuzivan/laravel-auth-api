<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\User;

use App\Models\User;
use GarbuzIvan\LaravelAuthApi\Configuration;
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
        if (is_null($user)) {
            $token = Str::random(80);
            $user = User::create([$field => $value, 'api_token' => $token]);
        } else {
            return $this->getUserTokenAfterAuth($user, $config);
        }
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
        } else {
            $token = Str::random(80);
            User::where('id', $user->id)->update(['api_token' => $token]);
            return $token;
        }
    }
}
