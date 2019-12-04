<?php

namespace PhpTool;

/**
 * Class IniSet
 * @package PhpTool
 * @author  huxiaolong
 * @date    2019/11/23 15:10
 */
class IniSet
{

    public static function get($varname = '')
    {
        return ini_get($varname);
    }

    public static function showErrors()
    {
        self::displayErrors(1);
        self::displayStartupErrors(1);
        self::errorReporting(1);
    }

    public static function hideErrors()
    {
        self::displayErrors(0);
        self::displayStartupErrors(0);
        self::errorReporting(0);
    }

    public static function displayErrors($status = 0)
    {
        ini_set('display_errors', !empty($status) ? 'On' : 'Off');

        //等价于下面的设置
//        ini_set('display_errors', !empty($status) ? 1 : 0);
//        ini_set('display_errors', !empty($status) ? '1' : '0');

    }

    public static function displayStartupErrors($status = 0)
    {
        ini_set('display_startup_errors', !empty($status) ? 'On' : 'Off');

        //等价于下面的设置
//        ini_set('display_errors', !empty($status) ? 1 : 0);
//        ini_set('display_errors', !empty($status) ? '1' : '0');

    }

    public static function errorReporting($status = 0)
    {
        error_reporting(!empty($status) ? E_ALL : 0);
//        error_reporting(E_ALL & ~E_NOTICE);
    }

    public static function logErrors($status = 0)
    {
        ini_set('log_errors', !empty($status) ? 'On' : 'Off');
    }

    public static function errorLog($filePath = '')
    {
        Debug::dd('ini_set只能设置全局的配置，error_log参数在HOST下单独设置，所以这里不会生效。');
//        ini_set('error_log', $filePath);
    }

    public static function memoryLimit($value = 0)
    {
        if (empty($value) || $value < 0)
            ini_set('memory_limit', -1);

        ini_set('memory_limit', $value . 'm');
    }

    public static function timeLimit($value = 0)
    {
        if (empty($value) || $value < 0)
            set_time_limit(0);

        set_time_limit($value);
    }

    public static function timeZone($value = '')
    {
        ini_set('date.timezone', !empty($value) ? $value : 'Asia/Shanghai');
    }

    public static function timeZoneOfChina()
    {
        self::timeZone('Asia/Shanghai');
    }

    public static function openBasedir($dirs = '')
    {
        //add: /tmp/:/proc/:
        ini_set('open_basedir', $dirs);
    }

}