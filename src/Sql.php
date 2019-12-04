<?php

namespace PhpTool;

/**
 * SQL 类
 * Class Sql
 * @author huxiaolong
 * @date   2019/11/18 14:19
 */
class Sql
{
    public static function getStatementForIn($array = [], $type = 'string')
    {
        if (empty($arr)) return " ('error') "; // 防止sql语句报错，写入：error
        $arr = Arr::force($arr);

        if (in_array($type, Constant::VAR_TYPES_OF_NUMBER)) {
            return " (" . implode(",", $arr) . ") ";
        }

        return " ('" . implode("','", $arr) . "') ";
    }
}