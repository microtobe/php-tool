<?php

namespace PhpTool;

/**
 * Created by PhpStorm.
 * User: huxiaolong
 * Date: 2019/10/21
 * Time: 14:29
 */
trait Singleton
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}