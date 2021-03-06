<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi\Pipes;

use GarbuzIvan\LaravelAuthApi\AuthStatus;
use GarbuzIvan\LaravelAuthApi\User\UserTransport;
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
        // handler
        $arg = $auth->getArg();
        // If the authorization was successful earlier - skip
        if (isset($arg['code']) || $auth->isSuccess()) {
            return $auth;
        }

        if (isset($arg['phone']) && !is_null($arg['phone'])) {
            // Validate phone
            $this->errorValidation($auth);
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
        if ($auth->isSuccess()) {
            return $auth;
        }
        // handler
        $arg = $auth->getArg();
        if (isset($arg['phone']) && isset($arg['code']) && isset($arg['pass'])) {
            // Validate phone
            $this->errorValidation($auth);
            $manager = app('otp');
            try {
                $manager->verifyOrFail($arg['code'], $arg['pass']);
            } catch (\OutOfBoundsException|VerificationException|LimitException $e) {
                $auth->setError($e->getMessage());
            }
            $token = (new UserTransport)->getUserOrCreate($this->replacePhone($arg['phone']), 'phone', $auth->config);
            $auth->setToken($token);
        }
        return $auth;
    }

    /**
     * @param string $phone
     * @return string
     */
    public function replacePhone(string $phone): string
    {
        return preg_replace('~[^0-9]~isuU', null, $phone);
    }

    /**
     * @param string $phone
     * @return bool
     */
    public function validation(string $phone): bool
    {
        return mb_strlen($this->replacePhone($phone)) == 11;
    }

    /**
     * @param $auth
     */
    public function errorValidation($auth)
    {
        $arg = $auth->getArg();
        $validation = $this->validation($arg['phone']);
        if(!$validation){
            $auth->setError('Телефон должен быть в формате 79871234567');
        }
    }
}
