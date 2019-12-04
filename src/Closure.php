<?php

namespace PhpTool;

/**
 * Created by PhpStorm.
 * User: huxiaolong
 * Date: 2019/10/21
 * Time: 14:29
 */
class Closure
{
    public static function strHandler(callable $callback, ...$strs)
    {
        return $callback(...$strs);
    }

    public static function arrHandler(callable $callback, $array)
    {
        if (empty($array) || !is_array($array)) return [];

        foreach ($array as $k => $v) {
            if ($callback($v, $v)) {
            }
        }
        call_user_func();
    }

}