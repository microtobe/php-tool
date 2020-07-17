<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class IniSet
 * @package PhpTool
 */
class IniSet
{

    /**
     * @param string $var
     * @return string
     */
    public static function get(string $var = '')
    {
        return \ini_get($var);
    }

    public static function showErrors()
    {
        self::displayErrors(true);
        self::displayStartupErrors(true);
        self::errorReporting(true);
    }

    public static function hideErrors()
    {
        self::displayErrors(false);
        self::displayStartupErrors(false);
        self::errorReporting(false);
    }

    /**
     * @param bool $status
     */
    public static function displayErrors(bool $status = false)
    {
        //等价
//        ini_set('display_errors', $status ? 1 : 0);
//        ini_set('display_errors', $status ? '1' : '0');

        \ini_set('display_errors', $status ? 'On' : 'Off');
    }

    /**
     * @param bool $status
     */
    public static function displayStartupErrors(bool $status = false)
    {
        //等价
//        ini_set('display_errors', $status ? 1 : 0);
//        ini_set('display_errors', $status ? '1' : '0');

        \ini_set('display_startup_errors', $status ? 'On' : 'Off');
    }

    /**
     * @param bool $status
     */
    public static function errorReporting(bool $status = false)
    {
        \error_reporting($status ? E_ALL : 0);
//        error_reporting(E_ALL & ~E_NOTICE);
    }

    /**
     * @param bool $status
     */
    public static function logErrors(bool $status = false)
    {
        \ini_set('log_errors', $status ? 'On' : 'Off');
    }

    /**
     * @param string $filePath
     */
    public static function errorLog(string $filePath = '')
    {
        Debug::dd('ini_set只能设置全局的配置，error_log参数在HOST下单独设置，所以这里不会生效。');
//        ini_set('error_log', $filePath);
    }

    /**
     * @param string $value
     */
    public static function memoryLimit(string $value = '')
    {
        if (empty($value)) {
            \ini_set('memory_limit', '-1');
        }

        if (is_numeric($value)) {
            if ($value <= 0) {
                \ini_set('memory_limit', '-1');
            }
            else {
                \ini_set('memory_limit', $value . 'm');
            }
        }

        \ini_set('memory_limit', $value);
    }

    /**
     * @param int $value
     */
    public static function timeLimit(int $value = 0)
    {
        if ($value <= 0) {
            \set_time_limit(0);
        }

        \set_time_limit($value);
    }

    /**
     * @param string $value
     */
    public static function timeZone(string $value = '')
    {
        \ini_set('date.timezone', !empty($value) ? $value : 'Asia/Shanghai');
    }

    public static function timeZoneOfChina()
    {
        self::timeZone('Asia/Shanghai');
    }
}
