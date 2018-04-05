<?php
namespace Dsheiko\Extras\Arrays\Underscore;

use Dsheiko\Extras\Type\PlainObject;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 * Arrays
 */
trait ArraysTrait
{

      /**
     * Get the first value from an array regardless index order and without modifying the array
     * @see http://underscorejs.org/#first
     *
     * @param array $array
     * @param mixed|callbale $defaultValue = null
     * @return mixed
     */
    public static function first(array $array, $defaultValue = null)
    {
        $val = \array_shift($array);
        return $defaultValue === null ? $val : ($val ?: static::resultOf($defaultValue));
    }

    /**
     * Get the last value from an array regardless index order and without modifying the array
     * @see http://underscorejs.org/#last
     *
     * @param array $array
     * @return mixed
     */
    public static function last(array $array)
    {
        return \array_pop($array);
    }


    /**
     * Returns everything but the last entry of the array. Especially useful on the arguments object.
     * Pass count to exclude the last count elements from the result.
     * @see http://underscorejs.org/#initial
     *
     * @param array $array
     * @param int $count
     * @return array
     */
    public static function initial(array $array, int $count = 1): array
    {
        return static::slice($array, \count($array) - 1);
    }

    /**
     * Similar to _.indexOf, returns the first index where the predicate truth test passes;
     * @see http://underscorejs.org/#findIndex
     *
     * @param array $array
     * @param callable $callable
     * @return mixed
     */
    public static function findIndex(array $array, callable $callable)
    {
        $el = static::find($array, $callable);
        return array_search($el, $array);
    }


    /**
     * Does the object contain the given key? Alias of hasOwnProperty
     * @param array $array
     * @see http://underscorejs.org/#has
     *
     * @param string $key
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        return static::hasOwnProperty($array, $key);
    }

    /**
     * Computes the list of values that are the intersection of all the arrays.
     * Each value in the result is present in each of the arrays.
     * @see http://underscorejs.org/#intersection
     * @see http://php.net/manual/en/function.array-intersect.php
     *
     * @param array $array
     * @param array ...$sources
     * @return array
     */
    public static function intersection(array $array, ...$sources): array
    {
        return static::isAssocArray($array)
            ? array_intersect_assoc($array, ...$sources)
            : array_intersect($array, ...$sources);
    }

    /**
     * Returns the values from array that are not present in the other arrays.
     * @see http://underscorejs.org/#difference
     * @see http://php.net/manual/en/function.array-diff.php
     *
     * @param array $array
     * @param array ...$sources
     * @return array
     */
    public static function difference(array $array, ...$sources): array
    {
        return static::isAssocArray($array)
            ? array_diff_assoc($array, ...$sources)
            : array_diff($array, ...$sources);
    }

    /**
     * Produces a duplicate-free version of the array
     * @see http://underscorejs.org/#uniq
     *
     * @param array $array
     * @return array
     */
    public static function uniq(array $array): array
    {
        return array_unique($array);
    }

    /**
     * Merges together the values of each of the arrays with the values at the corresponding position
     * @see http://underscorejs.org/#zip
     *
     * @param array $array
     * @param array ...$sources
     * @return array
     */
    public static function zip(array $array, ...$sources): array
    {
        $args = array_merge([$array], $sources);
        return array_map(null, ...$args);
    }

    /**
     * The opposite of zip. Given an array of arrays, returns a series of new arrays, the first of
     * which contains all of the first elements in the input arrays, the second of which contains
     * all of the second elements, and so on.
     * @see http://underscorejs.org/#unzip
     *
     * @param array $array
     * @return array
     */
    public static function unzip(array $array): array
    {
        $res = [];
        static::each($array, function (array $pojo) use (&$res) {
            static::each($pojo, function ($value, $inx) use (&$res) {
                $res[$inx] = $res[$inx] ?? [];
                $res[$inx][] = $value;
            });
        });
        return $res;
    }

    /**
     * Converts arrays into objects. Pass either a single list of [key, value] pairs, or a list of keys,
     * and a list of values. If duplicate keys exist, the last value wins.
     *
     * @param array $array
     * @return PlainObject
     */
    public static function object(array $array, array $values = null): PlainObject
    {
        if (!static::isAssocArray($array)) {
            $array = static::reduce(static::pairs($array), function (array $carry, $pair) use ($values) {
                list($inx, $item)  = $pair;
                if ($values !== null) {
                    $carry[$item] = $values[$inx];
                    return $carry;
                }
                $carry[$item[0]] = $item[1];
                return $carry;
            }, []);
        }
        return new PlainObject($array);
    }

}
