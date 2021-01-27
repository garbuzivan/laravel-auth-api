<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;
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
        $arg = $auth->getArg();
        $manager = app('otp');
        $address = new Address($arg['phone']);
        $otp = $manager->generateAndSend($address, 'sms');
        $status = [
            'step'  =>  'step2',
            'code'  =>  $otp->getVerificationCode(),
            'phone' =>  $arg['phone'],
            'pass'  =>  false,
        ];
        $auth->setStatus($status);
        return $auth;
    }

    /**
     * @param AuthStatus $auth
     * @return AuthStatus
     */
    public function authBySmsStep2(AuthStatus $auth): AuthStatus
    {
        $arg = $auth->getArg();
        return $auth;
    }
}
