<?php

namespace PhpTool;

/**
 * 调试，包括线上调试
 * Class Debug
 * @author huxiaolong
 * @date   2019/10/22 15:40
 */
class Debug
{

    public static function dd(...$vars)
    {
        var_dump(...$vars);
        echo '<br>';

        die(1);
    }

    public static function doc($content = '')
    {
        $var = <<<EOF
            $content;
EOF;

        echo $var;
    }
}