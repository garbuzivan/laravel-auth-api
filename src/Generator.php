<?php

declare(strict_types=1);

namespace GarbuzIvan\LaravelAuthApi;

class Generator
{
    /**
     * generate code
     *
     * @param Configuration $config
     * @return string
     */
    public static function code(Configuration $config): string
    {
        $charset = $config->getGeneratorCodeCharsets();
        $length = $config->getGeneratorCodeLength();
        $code = null;
        while($length > 0){
            $code .= $charset[array_rand($charset)];
            $length--;
        }
        return strval($code);
    }
}
