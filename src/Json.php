<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Json
 * @package PhpTool
 */
class Json
{

    private static $isJson = false;

    /**
     * 注意：先调用 Json::decode()，再调用 Json::isJson()才能判断
     * @return bool
     */
    public static function isJson(): bool
    {
        return self::$isJson;
    }

    /**
     * @param mixed $var
     * @return false|string
     */
    public static function encode($var = null)
    {
        return \json_encode($var, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $var
     * @param bool   $isAssoc
     * @return mixed|string
     */
    public static function decode(string $var = '', bool $isAssoc = true)
    {
        $data = \json_decode($var, $isAssoc);
        if (\json_last_error() == JSON_ERROR_NONE) {
            self::$isJson = true;

            return $data;
        }

        return $var;
    }
}
