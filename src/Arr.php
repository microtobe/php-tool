<?php

declare(strict_types=1);

namespace PhpTool;

/**
 * Class Arr
 * @package PhpTool
 */
class Arr
{

    /**
     * 强制为数组
     * @param mixed $var
     * @return array
     */
    public static function go($var = null): array
    {
        return is_array($var) ? $var : [];
    }

    /**
     * 强制为数组（转换）
     * If the given value is not an array and not null, wrap it in one.
     * @param  mixed $var
     * @return array
     */
    public static function wrap($var = null): array
    {
        if (is_null($var)) {
            return [];
        }

        return is_array($var) ? $var : [$var];
    }

    /**
     * 别名：self::wrap()
     * 强制为数组（转换）
     * @param mixed $var
     * @return array
     */
    public static function force($var = null): array
    {
        return self::wrap($var);
    }

    /**
     * 过滤空值
     * @param array $arr
     * @return array
     */
    public static function filter(array $arr = []): array
    {
        if (empty($arr)) {
            return [];
        }

        return array_filter($arr);
    }

    /**
     * 去重
     * @param array $arr
     * @return array
     */
    public static function unique(array $arr = []): array
    {
        if (empty($arr)) {
            return [];
        }

        return array_unique($arr);
    }

    /**
     * 封装函数：array_values()
     * @param array $arr
     * @return array
     */
    public static function values(array $arr = []): array
    {
        if (empty($arr)) {
            return [];
        }

        return array_values($arr);
    }

    /**
     * 过滤空值+去重
     * @param array $arr
     * @return array
     */
    public static function filterAndUnique(array $arr = []): array
    {
        return self::unique(self::filter($arr));
    }

    /**
     * 过滤空值+去重+重置索引
     * @param array $arr
     * @return array
     */
    public static function filterAndUniqueAndValues(array $arr = []): array
    {
        return self::values(self::unique(self::filter($arr)));
    }

    /**
     * 封装函数：array_map()
     * @param array $arr
     * @param mixed $callback
     * @return array
     */
    public static function map(array $arr = [], $callback = null): array
    {
        if (empty($arr)) {
            return [];
        }

        $arr = array_map($callback, $arr);

        return $arr;
    }

    /**
     * 将一维数组的每个元素使用 intval()
     * @param array $arr
     * @return array
     */
    public static function intValues(array $arr = []): array
    {
        return self::map($arr, 'intval');
    }

    /**
     * 将一维数组的每个元素使用 trim()
     * @param array $arr
     * @return array
     */
    public static function trim(array $arr = []): array
    {
        return self::map($arr, 'trim');
    }

    /**
     * 获取数组维度
     * @param array $arr
     * @return int
     */
    public static function depth(array $arr = []): int
    {
        if (empty($arr)) {
            return 0;
        }

        $maxDepth = 1;
        foreach ($arr as $v) {
            if (is_array($v)) {
                $depth = self::depth($v) + 1;

                if ($depth > $maxDepth) {
                    $maxDepth = $depth;
                }
            }
        }

        return $maxDepth;
    }

    /**
     * 封装函数：array_merge()
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    public static function merge(array $arr1 = [], array $arr2 = []): array
    {
        return array_merge($arr1, $arr2);
    }

    /**
     * 扩展函数array_column()，支持子数组column的提取
     * @param array $arr
     * @param mixed $columnKey
     * @param mixed $indexKey
     * @return array
     */
    public static function column(array &$arr = [], $columnKey = null, $indexKey = null)
    {
        if (empty($arr) || empty($columnKey)) {
            return [];
        }

        if (Common::isScalar($columnKey)) {
            return array_column($arr, $columnKey, $indexKey);
        }

        $result = [];
        if (is_array($columnKey) && count($columnKey) == 2) {
            foreach ($arr as $v) {
                if (isset($v[$columnKey[0]]) && is_array($v[$columnKey[0]])) {
                    $result[$v[$indexKey]] = $v[$columnKey[0]][$columnKey[1]] ?? '';
                }
            }

            return $result;
        }

        return [];
    }

    /**
     * 封装函数：max()
     * @param array $arr
     * @return int
     */
    public static function max(array $arr = []): int
    {
        if (empty($arr)) {
            return 0;
        }

        return max($arr);
    }

    /**
     * 数组扩展单元key
     * @example
     *         $arrayMaster = [['teacher_id' => 123], ['teacher_id' => 456]];
     *         $arraySlave = [[123 => 'Mark', 456 => 'Tom']];
     *         $result = arrayExtend($arrayMaster, $arraySlave, 'teacher_id', 'teacher_name')
     *         $result = [['teacher_id' => 123, 'teacher_name' => 'Mark'], ['teacher_id' => 456, 'teacher_name' =>
     *         'Tom']];
     * @param array  $arrayMaster
     * @param array  $arraySlave
     * @param string $keyAssoc
     * @param string $keyNew
     * @return array
     */
    public static function extend($arrayMaster = [], $arraySlave = [], $keyAssoc = '', $keyNew = ''): array
    {
        if (empty($arrayMaster) || empty($keyAssoc) || empty($arraySlave) || empty($keyNew)) {
            return $arrayMaster;
        }

        foreach ($arrayMaster as $k => $v) {
            $arrayMaster[$k][$keyNew] = '';
            if (isset($v[$keyAssoc])) {
                $arrayMaster[$k][$keyNew] = $arraySlave[$v[$keyAssoc]] ?? '';
            }
        }

        return $arrayMaster;
    }

    /**
     * @param array  $arrayMaster
     * @param array  $arraySlave
     * @param string $keyAssoc
     * @return array
     */
    public static function extendAll($arrayMaster = [], $arraySlave = [], $keyAssoc = ''): array
    {
        if (empty($arrayMaster) || empty($keyAssoc) || empty($arraySlave)) {
            return $arrayMaster;
        }

        foreach ($arrayMaster as $k => $v) {
            if (isset($v[$keyAssoc]) && !empty($arraySlave[$v[$keyAssoc]])) {
                $arrayMaster[$k] = $v + ($arraySlave[$v[$keyAssoc]] ?? []);
            }
        }

        return $arrayMaster;
    }

    /**
     * 获取数组中每个元素特定 key 的 sum
     * 注：key 必须为字符串
     * @param array  $arr
     * @param string $key
     * @return float|int
     */
    public static function keySum(array &$arr = [], string $key = '')
    {
        if (empty($arr) || empty($key)) {
            return 0;
        }

        return array_sum(self::column($arr, $key));
    }

    /**
     * 将二维数组转换成一维数组
     * @param array $arr
     * @return array
     */
    public static function flatten(array &$arr = []): array
    {
        $result = [];
        foreach ($arr as $v) {
            if (!is_array($v)) {
                continue;
            }

            $result[] = $v;
        }

        return array_merge([], ...$result);
    }

    /**
     * 获取数组特定key的sum()与特定key的sum()的比值
     * @param array  $arr
     * @param string $dividendKey 被除数 key
     * @param string $divisorKey  除数 key
     * @return float|int
     */
    public static function keyToKeySumRate(array &$arr = [], string $dividendKey = '', string $divisorKey = '')
    {
        return Number::division(self::keySum($arr, $dividendKey), self::keySum($arr, $divisorKey));
    }

    /**
     * 封装函数：unset()
     * 区别：返回结果数组
     * @param array $arr
     * @param mixed ...$keys
     * @return array
     */
    public static function unset(array &$arr = [], ...$keys): array
    {
        foreach ($keys as $key) {
            unset($arr[$key]);
        }

        return $arr;
    }

    /**
     * 别名：self::unset()
     * Get all of the given array except for a specified array of keys.
     * @param  array $arr
     * @param  mixed $keys
     * @return array
     */
    public static function except(array &$arr = [], ...$keys): array
    {
        return self::unset($arr, $keys);
    }

    /**
     * Get a subset of the items from the given array.
     * @param  array $arr
     * @param  mixed $key
     * @return array
     */
    public static function only(array &$arr = [], $key = null)
    {
        if (empty($arr) || empty($key)) {
            return [];
        }

        return array_intersect_key($arr, array_flip(self::force($key)));
    }

    /**
     * 数组(数字索引数组)：将 key 的数值增减
     * @param array $arr
     * @param int   $size
     * @return array
     */
    public static function increaseKey(array $arr = [], int $size = 1): array
    {
        if (empty($arr)) {
            return [];
        }

        if (empty($size)) {
            return $arr;
        }

        $return = [];
        foreach ($arr as $k => $v) {
            if (!is_numeric($k)) {
                $return[$k] = $v;
                continue;
            }

            $return[$k + $size] = $v;
        }

        return $return;
    }

    /**
     * 封装函数：array_push()，批量加到数组的末尾
     * 区别：本函数返回结果数组
     * @param array $arr
     * @param mixed ...$vars
     * @return array
     */
    public static function push(array &$arr = [], ...$vars): array
    {
        if (empty($vars)) {
            return $arr;
        }

        array_push($arr, ...$vars);

        return $arr;
    }

    /**
     * 增加数组的 value，不带 key
     * @param array $arr
     * @param mixed $var
     * @param bool  $addToFoot
     * @return array
     */
    public static function set(array &$arr = [], $var = null, bool $addToFoot = true): array
    {
        $addToFoot ? array_push($arr, $var) : array_unshift($arr, $var);

        return $arr;
    }

    /**
     * 头部增加数组的单元，带 key
     * Push an item onto the beginning of an array.
     * @param  array $arr
     * @param  mixed $var
     * @param  mixed $key
     * @param bool   $addToFoot
     * @return array
     */
    public static function setWithKey(array $arr = [], $var = null, $key = null, bool $addToFoot = true)
    {
        if (is_null($key)) {
            return self::set($arr, $var, $addToFoot);
        }

        if ($addToFoot) {
            $arr = $arr + [$key => $var];
        }
        else {
            $arr = [$key => $var] + $arr;
        }

        return $arr;
    }

    /**
     * 数组：根据 key 获取数组的 value
     * 可以用于多维数组，key 支持格式：0.name 或 [0, 'name']
     * @param array  $arr
     * @param mixed  $keys
     * @param string $default
     * @return array|string
     */
    public static function get(array $arr = [], $keys = '', $default = '')
    {
        $array = self::go($arr);
        if (is_float($keys) && $keys === 0.0) {
            $keys = '0.0';
        }

        if (is_numeric($keys)) {
            $keys = strval($keys);
        }

        if (is_string($keys)) {
            $keys = trim($keys, ' .');
        }

        if (empty($array) || (empty($keys) && $keys !== '0')) {
            return $array;
        }

        if (is_string($keys)) {
            $keys = explode('.', $keys);
        }

        if (!is_array($keys)) {
            return $default;
        }
        $keys = self::trim($keys);

        $value = $array;
        foreach ($keys as $key) {
            if (is_string($value)) {
                return $default;
            }
            $value = $value[$key] ?? $default;

            if (empty($value) && !is_array($value)) {
                return $value;
            }
        }

        return $value;
    }

    /**
     * 封装函数：in_array() ，严格模式判断！
     * @param mixed $var
     * @param array $arr
     * @return bool
     */
    public static function in($var = null, array $arr = []): bool
    {
        return in_array($var, $arr, true);
    }

    /**
     * 判断数组是否纯数组，即：key为0开始的递增整数
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     * @param  array $arr
     * @return bool
     */
    public static function isAssoc(array &$arr = []): bool
    {
        $keys = array_keys($arr);

        return array_keys($keys) !== $keys;
    }

    /**
     * Convert the array into a query string.
     * @param  array $arr
     * @return string
     */
    public static function query(array $arr = [])
    {
        return http_build_query($arr, '', '&', PHP_QUERY_RFC3986);
    }
}
