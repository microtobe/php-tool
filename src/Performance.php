<?php

namespace PhpTool;

/**
 * 性能
 * Class Performance
 * @author huxiaolong
 * @date   2019/10/21 14:34
 */
class Performance
{

    private static $startTime = 0;
    private static $stopTime  = 0;

    public static function start()
    {
        self::$startTime = self::getMicrotime();
    }

    public static function stop()
    {
        self::$stopTime = self::getMicrotime();
    }

    public static function profile()
    {
        if (empty(self::$startTime)) dd('请先设置开始时间');
        if (empty(self::$stopTime)) self::stop();

        printf("run time %f ms\r\n", ((float)(self::$stopTime) - (float)(self::$startTime)) * 1000);
    }

    public static function getMicrotime()
    {
        list($usec, $sec) = explode(' ', microtime());

        return (float)$usec + (float)$sec;
    }

}