<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use App\Models\User;
use GarbuzIvan\LaravelAuthApi\AuthStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Prozorov\DataVerification\Exceptions\LimitException;
use Prozorov\DataVerification\Exceptions\VerificationException;
use Prozorov\DataVerification\Types\Address;

class SmsAuth extends AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return mixed
     */
    public function auth(AuthStatus $auth): AuthStatus
    {
        $auth = $this->authBySmsStep2($auth);
        $auth = $this->authBySmsStep1($auth);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authBySmsStep1(AuthStatus $auth): AuthStatus
    {
        if (isset($arg['phone']) && !is_null($arg['phone'])) {
            $arg = $auth->getArg();
            $manager = app('otp');
            $address = new Address($arg['phone']);
            $otp = $manager->generateAndSend($address, 'sms');
            $status = [
                'step' => 'step2',
                'code' => $otp->getVerificationCode(),
                'phone' => $arg['phone'],
                'pass' => false,
            ];
            $auth->setStatus($status);
        }
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authBySmsStep2(AuthStatus $auth): AuthStatus
    {
        if (isset($arg['phone']) && isset($arg['code']) && isset($arg['pass'])) {
            $arg = $auth->getArg();
            $manager = app('otp');
            try {
                $manager->verifyOrFail($arg['code'], $arg['pass']);
            } catch (\OutOfBoundsException|VerificationException|LimitException $e) {
                $auth->setError($e->getMessage());
            }
            $newToken = Str::random(80);
            User::where('id', Auth::user()->id)->update(['api_token' => $newToken]);
            $auth->setToken($newToken);
        }
        return $auth;
    }
}
