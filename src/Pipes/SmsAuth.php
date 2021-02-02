<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;
use GarbuzIvan\LaravelAuthApi\User\UserTransport;
use Prozorov\DataVerification\Exceptions\LimitException;
use Prozorov\DataVerification\Exceptions\VerificationException;
use Prozorov\DataVerification\Types\Address;

class SmsAuth extends AbstractCommand
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
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
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
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        if (isset($arg['phone']) && isset($arg['code']) && isset($arg['pass'])) {
            $manager = app('otp');
            try {
                $manager->verifyOrFail($arg['code'], $arg['pass']);
            } catch (\OutOfBoundsException|VerificationException|LimitException $e) {
                $auth->setError($e->getMessage());
            }
            $token = (new UserTransport)->getUserOrCreate($arg['phone'], 'phone', $auth->config);
            $auth->setToken($token);
        }
        return $auth;
    }
}
