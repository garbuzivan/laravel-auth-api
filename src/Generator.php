<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

class Generator
{
    /**
     * generate code
     *
     * @return string
     */
    public static function code(): string
    {
        $charset = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $length = 4;
        $code = null;
        while($length > 0){
            $code = $charset[array_rand($charset)];
            $length--;
        }
        return strval($code);
    }
}
