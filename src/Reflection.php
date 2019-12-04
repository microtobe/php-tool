<?php

namespace PhpTool;

/**
 * Created by PhpStorm.
 * User: huxiaolong
 * Date: 2019/10/18
 * Time: 13:44
 */
class Reflection
{
    public static function getDocComment($class = '', $method = '', $type = '')
    {
        return self::fetchDocComment(self::getDocComments($class, $method), $type);
    }

    public static function getDocComments($class = '', $method = '')
    {
        if (!class_exists($class)) return '';

        $ref = new \ReflectionClass($class);
        if (empty($method)) {
            return $ref->getDocComment();
        }

        $methods = $ref->getMethods();
        foreach ($methods as $v) {
            if ($v->getName() == $method) {
                return $v->getDocComment();
            }
        }

        return '';
    }

    //******************************************************************************

    private static function fetchDocComment($docComments = '', $type = '')
    {
        if (empty($docComments) || empty($type)) return '';

        $typesArr       = Arr::map(explode('|', $type), 'trim');
        $docCommentsArr = Arr::map(explode(PHP_EOL, $docComments), 'trim');
        foreach ($typesArr as $type) {
            foreach ($docCommentsArr as $v) {
                if (($pos = mb_stripos($v, $type)) !== false) {
                    return trim(mb_substr($v, $pos + mb_strlen($type)));
                }
            }
        }

        return '';
    }

}