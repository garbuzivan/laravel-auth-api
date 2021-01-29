<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\User;

use App\Models\User;

class UserTransport
{
    public function getUserOrCreate($value, $token, $field = null): int
    {
        if(is_null($field)){
           return 0;
        }
        $user = User::where($field, $value)->first();
        if (is_null($user)) {
            $user = User::create([$field => $value]);
        }
        $update = ['api_token' => $token];
        if (is_null($user->name) || mb_strlen(trim($user->name)) == 0) {
            $update['name'] = 'ID' . $user->id;
        }
        $result = User::where('id', $user->id)->update($update);
        return $user->id;
    }
}
