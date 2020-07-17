<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Number
 * @package PhpTool
 */
class Number
{

    /**
     * 除法运算，$dividend是被除数，$divisor是除数
     * @param     $dividend  , 被除数,分子
     * @param     $divisor   , 除数，分母
     * @param int $precision , 保留小数的位数
     * @return float|int
     */
    public static function division($dividend, $divisor, int $precision = 4)
    {
        if (empty($dividend) || empty($divisor)) {
            return 0;
        }

        return self::round($dividend / $divisor, $precision);
    }

    /**
     * 浮点型数字四舍五入
     * @param float $val
     * @param int   $precision
     * @return float
     */
    public static function round($val = 0.0, int $precision = 2)
    {
        return round($val, $precision);
    }
}
