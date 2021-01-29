<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;
use Prozorov\DataVerification\Types\Address;

class EmailAuth extends AbstractPipes
{
    /**
     * Method of processing authorization and obtaining a token
     *
     * @param AuthStatus $auth
     * @return mixed
     */
    public function auth(AuthStatus $auth): AuthStatus
    {
        $auth = $this->authByEmailStep2($auth);
        $auth = $this->authByEmailStep1($auth);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authByEmailStep1(AuthStatus $auth): AuthStatus
    {
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        if (isset($arg['email']) && !is_null($arg['email'])) {
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
    public function authByEmailStep2(AuthStatus $auth): AuthStatus
    {
        // If the authorization was successful earlier - skip
        if($auth->isSuccess()){
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        return $auth;
    }
}
