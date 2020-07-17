<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Debug
 * @package PhpTool
 */
class Debug
{

    /**
     * @param mixed ...$vars
     */
    public static function dd(...$vars)
    {
        var_dump(...$vars);
        echo '<br>';

        die(1);
    }

    /**
     * @param string $content
     */
    public static function doc($content = '')
    {
        $var = <<<EOF
            $content;
EOF;

        echo $var;
    }
}
