<?php
/**
 * Created by PhpStorm.
 * User: huxiaolong
 * Date: 2019/11/23
 * Time: 16:12
 */

namespace PhpTool;

/**
 * Class AutoLoad
 * 注意：PSR-4规范
 * @package PhpTool
 * @author  huxiaolong
 * @date    2019/11/23 16:33
 */
class Loader
{

    /* 路径映射 */
    public static $vendorMap = [
        'PhpTool' => __DIR__ . DIRECTORY_SEPARATOR . 'src',
    ];

    /**
     * 自动加载器
     */
    public static function autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     */
    private static function findFile($class)
    {
        $vendor    = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录
        $filePath  = substr($class, strlen($vendor)) . '.php'; // 文件相对路径

        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
    }

    /**
     * 引入文件
     */
    private static function includeFile($file)
    {
        if (is_file($file)) {
            include $file;
        }
    }
}