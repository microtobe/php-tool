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
     * 强制为数组（不转换）
     * @param mix $var
     * @return array
     */
    function go($var = null): array
    {
        return is_array($var) ? $var : [];
    }

    /**
     * 强制转换为数组
     * @param mix $var
     * @return array
     */
    function force($var = null): array
    {
        if (is_null($var)) {
            return [];
        }

        return is_array($var) ? $var : [$var];
    }

    /**
     * 过滤空值
     * @param array $arr
     * @return array
     */
    function filter(array $arr = []): array
    {
        if (empty($arr) || !is_array($arr)) {
            return [];
        }

        return array_filter($arr);
    }

    /**
     * 去重
     * @param array $arr
     * @return array
     */
    function unique(array $arr = []): array
    {
        if (empty($arr) || !is_array($arr)) {
            return [];
        }

        return array_unique($arr);
    }

    /**
     * 封装函数：array_values()
     * @param array $arr
     * @return array
     */
    function values($arr = []): array
    {
        if (empty($arr) || !is_array($arr)) {
            return [];
        }

        return array_values($arr);
    }

    /**
     * 过滤空值+去重
     * @param array $arr
     * @return array
     */
    function filterAndUnique(array $arr = []): array
    {
        return $this->unique($this->filter($arr));
    }

    /**
     * 过滤空值+去重+重置索引
     * @param array $arr
     * @return array
     */
    function filterAndUniqueAndValues(array $arr = []): array
    {
        return $this->values($this->unique($this->filter($arr)));
    }

    /**
     * 封装函数：array_map()
     * @param array $arr
     * @param null  $callback
     * @return array
     */
    function map($arr = [], $callback = null): array
    {
        $arr = arrayForce($arr);
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
    function intValues($arr = []): array
    {
        return $this->map($arr, 'intval');
    }

    /**
     * 将一维数组的每个元素使用 trim()
     * @param array $arr
     * @return mixed
     */
    function trim($arr = []): array
    {
        return $this->map($arr, 'trim');
    }

    /**
     * 获取数组维度
     * @param array $array
     * @return int
     */
    function depth($array = []): int
    {
        if (!is_array($array)) {
            return 0;
        }

        $maxDepth = 1;
        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->depth($value) + 1;

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
    function merge($arr1 = [], $arr2 = []): array
    {
        return array_merge($this->force($arr1), $this->force($arr2));
    }

    /**
     * 扩展函数array_column()，支持子数组column的提取
     * @param array $arr
     * @param array $columnKeys
     * @param null  $indexKey
     * @return array
     */
    function column(&$arr = [], $columnKeys = [], $indexKey = null)
    {
        if (empty($arr) || !is_array($arr)) {
            return [];
        }

        if (isScalar($columnKeys)) {
            return array_column($arr, $columnKeys, $indexKey);
        }

        $result = [];
        if (is_array($columnKeys) && count($columnKeys) == 2) {
            foreach ($arr as $v) {
                if (isset($v[$columnKeys[0]]) && is_array($v[$columnKeys[0]])) {
                    $result[$v[$indexKey]] = $v[$columnKeys[0]][$columnKeys[1]] ?? '';
                }
            }

            return $result;
        }

        return [];
    }

    /**
     * 将二维数组格式化成三维数组
     * @param array  $arr
     * @param string $indexKey
     * @return array
     */
    function format(&$arr = [], $indexKey = '')
    {
        if (empty($arr) || !is_array($arr)) {
            return [];
        }

        if (empty($indexKey) || !is_string($indexKey)) {
            return $arr;
        }

        $result = [];
        foreach ($arr as $v) {
            $key = $v[$indexKey] ?? '';

            $result[$key][] = $v;
        }

        return $result;
    }

    /**
     * 封装函数：max()
     * @param array $arr
     * @return int|mixed
     */
    function max($arr = []): int
    {
        if (empty($arr) || !is_array($arr)) {
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
    function extend($arrayMaster = [], $arraySlave = [], $keyAssoc = '', $keyNew = ''): array
    {
        if (empty($arrayMaster) || empty($keyAssoc) || empty($arraySlave) || empty($keyNew)) return $arrayMaster;

        foreach ($arrayMaster as $k => $v) {
            $arrayMaster[$k][$keyNew] = '';
            if (isset($v[$keyAssoc])) {
                $arrayMaster[$k][$keyNew] = $arraySlave[$v[$keyAssoc]] ?? '';
            }
        }

        return $arrayMaster;
    }

    function extendAll($arrayMaster = [], $arraySlave = [], $keyAssoc = ''): array
    {
        if (empty($arrayMaster) || empty($keyAssoc) || empty($arraySlave)) return $arrayMaster;

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
     * @param array  $array
     * @param string $key
     * @return float|int
     */
    function keySum(&$array = [], $key = '')
    {
        if (empty($array) || empty($key) || !is_array($array) || !is_string($key)) {
            return 0;
        }

        $arrayKeyValues = arrayColumn($array, $key);

        return array_sum($arrayKeyValues);
    }

    /**
     * 三维：获取子数组中每个单元特定 key 的 sum
     * 注：key 必须为字符串
     * @param array  $array
     * @param string $key
     * @return int
     */
    function keySumFor3D(&$array = [], $key = '')
    {
        if (empty($array) || empty($key) || !is_array($array) || !is_string($key)) {
            return 0;
        }

        $sum = 0;
        foreach ($array as $v) {
            if (is_array($v)) {
                $sum += $this->keySum($v, $key);
            }
        }

        return $sum;
    }

    /**
     * 封装函数：array_push()
     * 区别：本函数返回结果数组
     * @param array $arr
     * @param mix   $value
     * @return array
     */
    function push(array &$arr = [], $value = null): array
    {
        if (empty($arr) || !is_array($arr)) {
            return $arr;
        }

        array_push($arr, $value);

        return $arr;
    }

    /**
     * 二维数组：将数组的每一个数组折成单一数组
     */
if (!function_exists('arrayFlatten'))
{

    function arrayFlatten(&$array)
    {
        $results = [];

        foreach ($array as $values) {
            if (!is_array($values)) {
                continue;
            }

            $results[] = $values;
        }

        return array_merge([], ...$results);
    }
}

/**
 * 获取数组特定key的sum()与特定key的sum()的比值
 * @param array  $statList
 * @param string $dividendKey
 * @param string $divisorKey
 * @return float|int
 */
if (!function_exists('arrayKeyToKeyTotalRate')) {
    function arrayKeyToKeyTotalRate(&$arr = [], $dividendKey = '', $divisorKey = '')
    {
        return division(arrayKeySum($arr, $dividendKey), arrayKeySum($arr, $divisorKey));
    }
}

/**
 * 获取数组特定key的sum()与特定key的sum()的比值
 * @param array  $statList
 * @param string $dividendKey
 * @param string $divisorKey
 * @return float|int
 */
if (!function_exists('arrayKeyToKeyTotalRate')) {
    function arrayKeyToKeyTotalRate(&$arr = [], $dividendKey = '', $divisorKey = '')
    {
        return division(arrayKeySum($arr, $dividendKey), arrayKeySum($arr, $divisorKey));
    }
}

/**
 * 一维数组：unset() 函数的封装
 * @param array $input
 * @param mixed ...$keys
 * @return array
 */
if (!function_exists('arrayUnset')) {
    function arrayUnset($input = [], ...$keys)
    {
        foreach ($keys as $key) {
            unset($input[$key]);
        }

        return $input;
    }
}

/**
 * 二维数组排序 - 根据二维数组中某一个（或几个，最大不超过3个）中文key排序
 * @param      $array
 * @param      $key
 * @param bool $desc
 * @return array
 */
if (!function_exists('arraySortByCnKey')) {
    function arraySortByCnKey(&$array, $keyArr = [], $desc = false)
    {
        if (empty($array) || !is_array($array) || empty($keyArr)) return [];
        if (is_string($keyArr)) $keyArr = [$keyArr];
        $keyArr = arrayIndexValue($keyArr);

        if (count($keyArr) == 1) {
            $key1 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $array);
        }
        else if (count($keyArr) == 2) {
            $key1 = $key2 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
                $key2[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[1]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $key2, $sort, $array);
        }
        else if (count($keyArr) == 3) {
            $key1 = $key2 = $key3 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
                $key2[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[1]] ?? ''); //中文转换成 GBK 即可排序
                $key3[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[2]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $key2, $sort, $key3, $sort, $array);
        }
        else if (count($keyArr) == 4) {
            $key1 = $key2 = $key3 = $key4 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
                $key2[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[1]] ?? ''); //中文转换成 GBK 即可排序
                $key3[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[2]] ?? ''); //中文转换成 GBK 即可排序
                $key4[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[3]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $key2, $sort, $key3, $sort, $key4, $sort, $array);
        }
        else if (count($keyArr) == 5) {
            $key1 = $key2 = $key3 = $key4 = $key5 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
                $key2[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[1]] ?? ''); //中文转换成 GBK 即可排序
                $key3[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[2]] ?? ''); //中文转换成 GBK 即可排序
                $key4[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[3]] ?? ''); //中文转换成 GBK 即可排序
                $key5[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[4]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $key2, $sort, $key3, $sort, $key4, $sort, $key5, $sort, $array);
        }
        else if (count($keyArr) == 6) {
            $key1 = $key2 = $key3 = $key4 = $key5 = $key6 = [];
            foreach ($array as $k => $v) {
                $key1[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[0]] ?? ''); //中文转换成 GBK 即可排序
                $key2[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[1]] ?? ''); //中文转换成 GBK 即可排序
                $key3[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[2]] ?? ''); //中文转换成 GBK 即可排序
                $key4[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[3]] ?? ''); //中文转换成 GBK 即可排序
                $key5[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[4]] ?? ''); //中文转换成 GBK 即可排序
                $key6[$k] = iconv('UTF-8', 'GBK//IGNORE', $v[$keyArr[5]] ?? ''); //中文转换成 GBK 即可排序
            }
            $sort = empty($desc) ? SORT_ASC : SORT_DESC;

            array_multisort($key1, $sort, $key2, $sort, $key3, $sort, $key4, $sort, $key5, $sort, $key6, $sort, $array);
        }
    }
}

/**
 * 数组(数字索引数组)：将 key 的数值增减
 * @param      $array
 * @param      $size
 * @return array
 */
if (!function_exists('arrayAlterKey')) {
    function arrayAlterKey($array, $size = 1)
    {
        if (empty($array) || !is_array($array)) return [];

        $return = [];
        foreach ($array as $k => $v) {
            if (!is_numeric($k)) {
                $return[$k] = $v;
                continue;
            }

            $return[$k + $size] = $v;
        }

        return $return;
    }
}

/**
 * 数组：根据 key 获取数组的 value
 * 可以用于多维数组，key 支持格式：0.name 或 [0, 'name']
 */
if (!function_exists('arrayGet')) {
    function arrayGet($array = [], $keys = '', $default = '')
    {
        $array = arrayGo($array);
        if (is_float($keys) && $keys === 0.0) $keys = '0.0';
        if (is_numeric($keys)) $keys = strval($keys);
        if (is_string($keys)) $keys = trim($keys, ' .');
        if (empty($array) || (empty($keys) && $keys !== '0')) return $array;

        if (is_string($keys)) {
            $keys = explode('.', $keys);
        }

        if (!is_array($keys)) return $default;
        $keys = arrayTrim($keys);

        $value = $array;
        foreach ($keys as $key) {
            if (is_string($value)) return $default;
            $value = $value[$key] ?? $default;

            if (empty($value) && !is_array($value)) return $value;
        }

        return $value;
    }
}

/**
 * 数组：in_array() 函数的封装，严格模式判断！
 */
if (!function_exists('inArray')) {
    function inArray($value = '', array $array = [])
    {
        return in_array($value, arrayForce($array), true);
    }
}

/**
 * 二维数组排序 - 根据二维数组中某一个key排序
 * @param      $array
 * @param      $key
 * @param bool $desc
 * @return array
 */
public
static function SortByKeyFor2D(array &$array, string $key, bool $desc = false): array
{
    if (empty($array) || !is_array($array)) return [];

    $keyArr = [];
    foreach ($array as $k => $v) {
        $keyArr[$k] = $v[$key] ?? '';
    }
    $sort = empty($desc) ? SORT_ASC : SORT_DESC;

    array_multisort($keyArr, $sort, SORT_NUMERIC, $array);
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
public
static function extend(array $arrayMaster = [], array $arraySlave = [], string $keyAssoc = '', string $keyNew = ''): array
{
    if (empty($arrayMaster) || empty($keyAssoc) || empty($arraySlave) || empty($keyNew)) return $arrayMaster;

    foreach ($arrayMaster as $k => $v) {
        $arrayMaster[$k][$keyNew] = '';
        if (isset($v[$keyAssoc])) {
            $arrayMaster[$k][$keyNew] = $arraySlave[$v[$keyAssoc]] ?? '';
        }
    }

    return $arrayMaster;
}

/**
 * 扩展函数array_column()，支持子数组column的提取
 * @param array  $arr
 * @param array  $columnKeys
 * @param string $indexKey
 * @return array
 */
public
static function column(array $arr = [], $columnKeys = [], $indexKey = null): array
{
    if (empty($arr) || !is_array($arr)) return [];
    if (is_string($columnKeys)) return array_column($arr, $columnKeys, $indexKey);

    $result = [];
    if (is_array($columnKeys) && count($columnKeys) == 2) {
        foreach ($arr as $v) {
            if (isset($v[$columnKeys[0]]) && is_array($v[$columnKeys[0]])) {
                $result[$v[$indexKey]] = $v[$columnKeys[0]][$columnKeys[1]] ?? '';
            }
        }

        return $result;
    }

    return [];
}

/**
 * 将数组元素 intval()
 * @param array $arr
 * @return array|int|string
 */
public
static function intValues(array $arr = []): array
{
    $arr = self::force($arr);
    if (empty($arr)) return [];

    $arr = self::map($arr, 'intval');
    $arr = self::filter($arr);

    return $arr;
}

/**
 * 过滤0值数组+去重
 * @param array $arr
 * @return array
 */
public
static function filterAndUnique(array $arr = []): array
{
    return self::unique(self::filter($arr));
}

/**
 * 封装 array_filter()
 * @param array         $input
 * @param callable|null $callback
 * @param int           $flag
 * @return array
 */
public
static function filter(array $input = [], callable $callback = null, int $flag = 0): array
{
    if (empty($input) || !is_array($input)) return [];

    return array_filter($input, $callback, $flag);
}

/**
 * 封装 array_unique()
 * @param array $input
 * @param int   $sortFlags
 * @return array
 */
public
static function unique(array $input = [], int $sortFlags = SORT_STRING): array
{
    if (empty($input) || !is_array($input)) return [];

    return array_unique($input, $sortFlags);
}

/**
 * 将变量强制转换成数组
 * @param string $value
 * @return array
 */
public
static function force($value = ''): array
{
    if (is_null($value)) {
        return [];
    }

    return is_array($value) ? $value : [$value];
}

/**
 * 封装 array_map()
 * @param array $arr
 * @param null  $callback
 * @return array
 */
public
static function map($arr = [], $callback = null)
{
    $arr = self::force($arr);
    if (empty($arr)) return [];

    $arr = array_map($callback, $arr);

    return $arr;
}

/**
 * 一维数组：每个元素分别使用 trim()
 * @param array $arr
 * @return array
 */
public
static function trim($arr = [])
{
    return self::map($arr, 'trim');
}

/**
 * 获取数组的维度，如果不是数组，返回：0；空数组，返回：1；
 * @param array $array
 * @return int
 */
public
static function depth($array = [])
{
    if (!is_array($array)) return 0;

    $maxDepth = 1;
    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = self::depth($value) + 1;

            if ($depth > $maxDepth) {
                $maxDepth = $depth;
            }
        }
    }

    return $maxDepth;
}

/**
 * Determine whether the given value is array accessible.
 * @param  mixed $value
 * @return bool
 */
public
static function accessible($value)
{
    return is_array($value) || $value instanceof ArrayAccess;
}

/**
 * Add an element to an array using "dot" notation if it doesn't exist.
 * @param  array  $array
 * @param  string $key
 * @param  mixed  $value
 * @return array
 */
public
static function add($array, $key, $value)
{
    if (is_null(static::get($array, $key))) {
        static::set($array, $key, $value);
    }

    return $array;
}

/**
 * Collapse an array of arrays into a single array.
 * @param  array $array
 * @return array
 */
public
static function collapse($array)
{
    $results = [];

    foreach ($array as $values) {
        if ($values instanceof Collection) {
            $values = $values->all();
        }
        elseif (!is_array($values)) {
            continue;
        }

        $results[] = $values;
    }

    return array_merge([], ...$results);
}

/**
 * Cross join the given arrays, returning all possible permutations.
 * @param  array ...$arrays
 * @return array
 */
public
static function crossJoin(...$arrays)
{
    $results = [[]];

    foreach ($arrays as $index => $array) {
        $append = [];

        foreach ($results as $product) {
            foreach ($array as $item) {
                $product[$index] = $item;

                $append[] = $product;
            }
        }

        $results = $append;
    }

    return $results;
}

/**
 * Divide an array into two arrays. One with keys and the other with values.
 * @param  array $array
 * @return array
 */
public
static function divide($array)
{
    return [array_keys($array), array_values($array)];
}

/**
 * Flatten a multi-dimensional associative array with dots.
 * @param  array  $array
 * @param  string $prepend
 * @return array
 */
public
static function dot($array, $prepend = '')
{
    $results = [];

    foreach ($array as $key => $value) {
        if (is_array($value) && !empty($value)) {
            $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
        }
        else {
            $results[$prepend . $key] = $value;
        }
    }

    return $results;
}

/**
 * Get all of the given array except for a specified array of keys.
 * @param  array        $array
 * @param  array|string $keys
 * @return array
 */
public
static function except($array, $keys)
{
    static::forget($array, $keys);

    return $array;
}

/**
 * Determine if the given key exists in the provided array.
 * @param  \ArrayAccess|array $array
 * @param  string|int         $key
 * @return bool
 */
public
static function exists($array, $key)
{
    if ($array instanceof ArrayAccess) {
        return $array->offsetExists($key);
    }

    return array_key_exists($key, $array);
}

/**
 * Return the first element in an array passing a given truth test.
 * @param  array         $array
 * @param  callable|null $callback
 * @param  mixed         $default
 * @return mixed
 */
public
static function first($array, callable $callback = null, $default = null)
{
    if (is_null($callback)) {
        if (empty($array)) {
            return value($default);
        }

        foreach ($array as $item) {
            return $item;
        }
    }

    foreach ($array as $key => $value) {
        if (call_user_func($callback, $value, $key)) {
            return $value;
        }
    }

    return value($default);
}

/**
 * Return the last element in an array passing a given truth test.
 * @param  array         $array
 * @param  callable|null $callback
 * @param  mixed         $default
 * @return mixed
 */
public
static function last($array, callable $callback = null, $default = null)
{
    if (is_null($callback)) {
        return empty($array) ? value($default) : end($array);
    }

    return static::first(array_reverse($array, true), $callback, $default);
}

/**
 * Flatten a multi-dimensional array into a single level.
 * @param  array $array
 * @param  int   $depth
 * @return array
 */
public
static function flatten($array, $depth = INF)
{
    $result = [];

    foreach ($array as $item) {
        $item = $item instanceof Collection ? $item->all() : $item;

        if (!is_array($item)) {
            $result[] = $item;
        }
        else {
            $values = $depth === 1
                ? array_values($item)
                : static::flatten($item, $depth - 1);

            foreach ($values as $value) {
                $result[] = $value;
            }
        }
    }

    return $result;
}

/**
 * Remove one or many array items from a given array using "dot" notation.
 * @param  array        $array
 * @param  array|string $keys
 * @return void
 */
public
static function forget(&$array, $keys)
{
    $original = &$array;

    $keys = (array)$keys;

    if (count($keys) === 0) {
        return;
    }

    foreach ($keys as $key) {
        // if the exact key exists in the top-level, remove it
        if (static::exists($array, $key)) {
            unset($array[$key]);

            continue;
        }

        $parts = explode('.', $key);

        // clean up before each pass
        $array = &$original;

        while (count($parts) > 1) {
            $part = array_shift($parts);

            if (isset($array[$part]) && is_array($array[$part])) {
                $array = &$array[$part];
            }
            else {
                continue 2;
            }
        }

        unset($array[array_shift($parts)]);
    }
}

/**
 * Get an item from an array using "dot" notation.
 * @param  \ArrayAccess|array $array
 * @param  string|int         $key
 * @param  mixed              $default
 * @return mixed
 */
public
static function get($array, $key, $default = null)
{
    if (!static::accessible($array)) {
        return value($default);
    }

    if (is_null($key)) {
        return $array;
    }

    if (static::exists($array, $key)) {
        return $array[$key];
    }

    if (strpos($key, '.') === false) {
        return $array[$key] ?? value($default);
    }

    foreach (explode('.', $key) as $segment) {
        if (static::accessible($array) && static::exists($array, $segment)) {
            $array = $array[$segment];
        }
        else {
            return value($default);
        }
    }

    return $array;
}

/**
 * Check if an item or items exist in an array using "dot" notation.
 * @param  \ArrayAccess|array $array
 * @param  string|array       $keys
 * @return bool
 */
public
static function has($array, $keys)
{
    $keys = (array)$keys;

    if (!$array || $keys === []) {
        return false;
    }

    foreach ($keys as $key) {
        $subKeyArray = $array;

        if (static::exists($array, $key)) {
            continue;
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                $subKeyArray = $subKeyArray[$segment];
            }
            else {
                return false;
            }
        }
    }

    return true;
}

/**
 * Determines if an array is associative.
 * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
 * @param  array $array
 * @return bool
 */
public
static function isAssoc(array $array)
{
    $keys = array_keys($array);

    return array_keys($keys) !== $keys;
}

/**
 * Get a subset of the items from the given array.
 * @param  array        $array
 * @param  array|string $keys
 * @return array
 */
public
static function only($array, $keys)
{
    return array_intersect_key($array, array_flip((array)$keys));
}

/**
 * Pluck an array of values from an array.
 * @param  array             $array
 * @param  string|array      $value
 * @param  string|array|null $key
 * @return array
 */
public
static function pluck($array, $value, $key = null)
{
    $results = [];

    [$value, $key] = static::explodePluckParameters($value, $key);

    foreach ($array as $item) {
        $itemValue = data_get($item, $value);

        // If the key is "null", we will just append the value to the array and keep
        // looping. Otherwise we will key the array using the value of the key we
        // received from the developer. Then we'll return the final array form.
        if (is_null($key)) {
            $results[] = $itemValue;
        }
        else {
            $itemKey = data_get($item, $key);

            if (is_object($itemKey) && method_exists($itemKey, '__toString')) {
                $itemKey = (string)$itemKey;
            }

            $results[$itemKey] = $itemValue;
        }
    }

    return $results;
}

/**
 * Explode the "value" and "key" arguments passed to "pluck".
 * @param  string|array      $value
 * @param  string|array|null $key
 * @return array
 */
protected
static function explodePluckParameters($value, $key)
{
    $value = is_string($value) ? explode('.', $value) : $value;

    $key = is_null($key) || is_array($key) ? $key : explode('.', $key);

    return [$value, $key];
}

/**
 * Push an item onto the beginning of an array.
 * @param  array $array
 * @param  mixed $value
 * @param  mixed $key
 * @return array
 */
public
static function prepend($array, $value, $key = null)
{
    if (is_null($key)) {
        array_unshift($array, $value);
    }
    else {
        $array = [$key => $value] + $array;
    }

    return $array;
}

/**
 * Get a value from the array, and remove it.
 * @param  array  $array
 * @param  string $key
 * @param  mixed  $default
 * @return mixed
 */
public
static function pull(&$array, $key, $default = null)
{
    $value = static::get($array, $key, $default);

    static::forget($array, $key);

    return $value;
}

/**
 * Get one or a specified number of random values from an array.
 * @param  array    $array
 * @param  int|null $number
 * @return mixed
 * @throws \InvalidArgumentException
 */
public
static function random($array, $number = null)
{
    $requested = is_null($number) ? 1 : $number;

    $count = count($array);

    if ($requested > $count) {
        throw new InvalidArgumentException(
            "You requested {$requested} items, but there are only {$count} items available."
        );
    }

    if (is_null($number)) {
        return $array[array_rand($array)];
    }

    if ((int)$number === 0) {
        return [];
    }

    $keys = array_rand($array, $number);

    $results = [];

    foreach ((array)$keys as $key) {
        $results[] = $array[$key];
    }

    return $results;
}

/**
 * Set an array item to a given value using "dot" notation.
 * If no key is given to the method, the entire array will be replaced.
 * @param  array  $array
 * @param  string $key
 * @param  mixed  $value
 * @return array
 */
public
static function set(&$array, $key, $value)
{
    if (is_null($key)) {
        return $array = $value;
    }

    $keys = explode('.', $key);

    while (count($keys) > 1) {
        $key = array_shift($keys);

        // If the key doesn't exist at this depth, we will just create an empty array
        // to hold the next value, allowing us to create the arrays to hold final
        // values at the correct depth. Then we'll keep digging into the array.
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = [];
        }

        $array = &$array[$key];
    }

    $array[array_shift($keys)] = $value;

    return $array;
}

/**
 * Shuffle the given array and return the result.
 * @param  array    $array
 * @param  int|null $seed
 * @return array
 */
public
static function shuffle($array, $seed = null)
{
    if (is_null($seed)) {
        shuffle($array);
    }
    else {
        mt_srand($seed);
        shuffle($array);
        mt_srand();
    }

    return $array;
}

/**
 * Sort the array using the given callback or "dot" notation.
 * @param  array                $array
 * @param  callable|string|null $callback
 * @return array
 */
public
static function sort($array, $callback = null)
{
    return Collection::make($array)->sortBy($callback)->all();
}

/**
 * Recursively sort an array by keys and values.
 * @param  array $array
 * @return array
 */
public
static function sortRecursive($array)
{
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = static::sortRecursive($value);
        }
    }

    if (static::isAssoc($array)) {
        ksort($array);
    }
    else {
        sort($array);
    }

    return $array;
}

/**
 * Convert the array into a query string.
 * @param  array $array
 * @return string
 */
public
static function query($array)
{
    return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
}

/**
 * Filter the array using the given callback.
 * @param  array    $array
 * @param  callable $callback
 * @return array
 */
public
static function where($array, callable $callback)
{
    return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
}

/**
 * If the given value is not an array and not null, wrap it in one.
 * @param  mixed $value
 * @return array
 */
public
static function wrap($value)
{
    if (is_null($value)) {
        return [];
    }

    return is_array($value) ? $value : [$value];
}

}
