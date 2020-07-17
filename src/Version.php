<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Version
 * @package PhpTool
 */
class Version
{

    /**
     * 当前版本号
     * @return string
     */
    public static function now(): string
    {
        $version = '0.2.1';

        return $version;
    }
}
