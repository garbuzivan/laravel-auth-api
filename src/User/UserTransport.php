<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\User;

use App\Models\User;

class UserTransport
{
    public function getUserOrCreatePhone($phone, $token): int
    {
        $user = User::where('phone', $phone)->first();
        if (is_null($user)) {
            $user = User::create(['phone' => $phone]);
        }
        $update = ['api_token' => $token];
        if (is_null($user->name) || mb_strlen(trim($user->name)) == 0) {
            $update['name'] = 'ID' . $user->id;
        }
        $result = User::where('id', $user->id)->update($update);
        return $user->id;
    }

    public function getUserOrCreateEmail($email, $token): int
    {
        $user = User::where('email', $email)->first();
        if (is_null($email)) {
            $user = User::create(['email' => $email]);
        }
        $update = ['api_token' => $token];
        if (is_null($user->name) || mb_strlen(trim($user->name)) == 0) {
            $update['name'] = 'ID' . $user->id;
        }
        $result = User::where('id', $user->id)->update($update);
        return $user->id;
    }
}
