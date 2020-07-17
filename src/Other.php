<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Other
 * @package PhpTool
 */
class Other
{

    /**
     * 检查变量是否标量
     * 标量类型包括：'int','string','float','boolean'
     * @param mixed $var
     * @return bool
     */
    public static function isScalar($var = null)
    {
        if (is_string($var) || is_numeric($var) || is_bool($var)) {
            return true;
        }

        return false;
    }
}
