<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\User;

use App\Models\User;
use GarbuzIvan\LaravelAuthApi\Configuration;
use Illuminate\Support\Str;

class UserTransport
{
    public function getUserOrCreate($value, $field = 'email', Configuration $config): ?string
    {
        if (is_null($field)) {
            return null;
        }
        $update = [];
        $user = User::where($field, $value)->first();
        $token = Str::random(80);
        if (is_null($user)) {
            $user = User::create([$field => $value, 'api_token' => $token]);
        } else {
            $token = $user->api_token;
            if ($config->isNewToken()) {
                $update = ['api_token' => $token];
            }
        }
        if (is_null($user->name) || mb_strlen(trim($user->name)) == 0) {
            $update['name'] = 'ID' . $user->id;
        }
        if (is_array($update) && count($update) > 0) {
            User::where('id', $user->id)->update($update);
        }
        return $token;
    }
}
