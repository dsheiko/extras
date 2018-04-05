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
        return static::slice($array, 0, \count($array) - $count);
    }

    /**
     * Returns the rest of the elements in an array. Pass an index to
     * return the values of the array from that index onward.
     * @see http://underscorejs.org/#rest
     *
     * @param array $array
     * @param int $count
     * @return array
     */
    public static function rest(array $array, int $count = 1): array
    {
        return static::slice($array, $count);
    }

    /**
     * Returns a copy of the array with all falsy values removed.
     * @see http://underscorejs.org/#compact
     *
     * @param array $array
     * @return array
     */
    public static function compact(array $array): array
    {
        return static::filter($array);
    }

    /**
     * Helper: flatten
     *
     * @param array $array
     * @param bool $shallow
     * @param bool $strict
     * @param int $startIndex
     * @return array
     */
    protected static function flattening(array $array, bool $shallow, bool $strict, int $startIndex = 0): array
    {
        return static::reduce($array, function ($carry, $value, $i) use ($shallow, $strict, $startIndex) {
            if ($i < $startIndex) {
                return $carry;
            }
            if (!\is_array($value) && $strict) {
                return $carry;
            }
            if (!\is_array($value) && !$strict) {
                $carry[] = $value;
                return $carry;
            }
            if (!$shallow) {
                $value = static::flattening($value, $shallow, $strict);
            }
            return \array_merge($carry, $value);
        }, []);
    }

    /**
     * Flattens a nested array (the nesting can be to any depth). If you pass shallow,
     * the array will only be flattened a single level.
     * http://underscorejs.org/#flatten
     *
     * @param array $array
     * @param bool $shallow
     * @return array
     */
    public static function flatten(array $array, bool $shallow = false): array
    {
        return static::flattening($array, $shallow, false);
    }

    /**
     * Returns a copy of the array with all instances of the values removed.
     * @see http://underscorejs.org/#without
     *
     * @param array $array
     * @param array ...$values
     * @return array
     */
    public static function without(array $array, ...$values): array
    {
        return static::difference($array, $values);
    }

    /**
     * Computes the union of the passed-in arrays: the list of unique items,
     * in order, that are present in one or more of the arrays.
     * @see http://underscorejs.org/#union
     *
     * @param array ...$args
     * @return array
     */
    public static function union(...$args): array
    {
        return static::uniq(static::flattening($args, true, true));
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
            ? \array_intersect_assoc($array, ...$sources)
            : \array_values(\array_intersect($array, ...$sources));
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
            ? \array_diff_assoc($array, ...$sources)
            : \array_values(\array_diff($array, ...$sources));
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
        $res = \array_unique($array);
        return static::isAssocArray($array) ? $res : \array_values($res);
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

     /**
     * Similar to indexOf, returns the first index where the predicate truth test passes;
     * @see http://underscorejs.org/#findIndex
     *
     * @param array $array
     * @param callable $callable
     * @return mixed
     */
    public static function findIndex(array $array, $iteratee = null, $context = null)
    {
        $iterateeNorm = static::cb($iteratee, $context);
        $el = static::find($array, $iterateeNorm);
        return array_search($el, $array);
    }

    /**
     * Like findIndex but iterates the array in reverse,
     * returning the index closest to the end where the predicate truth test passes.
     * @see http://underscorejs.org/#findLastIndex
     *
     * @param array $array
     * @param callable|string $iteratee
     * @param object $context
     * @return int
     */
    public static function findLastIndex(array $array, $iteratee = null, $context = null): int
    {
        $iterateeNorm = static::cb($iteratee, $context);
        $res = static::filter($array, $iterateeNorm);
        $el = count($res) ? static::last($res) : null;
        return array_search($el, $array);
    }

    /**s
     * Uses a binary search to determine the index at which the value should be
     * inserted into the list in order to maintain the list's sorted order.
     * If an iteratee function is provided, it will be used to compute the sort ranking of
     * each value, including the value you pass. The iteratee may also be the string
     * name of the property to sort by
     * @see http://underscorejs.org/#sortedIndex
     *
     * @param array $array
     * @param mixed $rawValue
     * @param callable|string $iteratee
     * @param objct $context
     * @return int
     */
    public static function sortedIndex(array $array, $rawValue, $iteratee = null, $context = null): int
    {
        $iteratee = static::cb($iteratee, $context);
        $value = $iteratee($rawValue);
        $low = 0;
        $high = \count($array);
        while ($low < $high) {
            $mid = \floor(($low + $high) / 2);
            if ($iteratee($array[$mid]) < $value) {
                $low = $mid + 1;
            } else {
                $high = $mid;
            }
        }
        return $low;
    }

    /**
     * A function to create flexibly-numbered lists of integers, handy for each and map loops. start,
     * if omitted, defaults to 0; step defaults to 1.
     * Returns a list of integers from start (inclusive) to stop (exclusive), incremented (or decremented)
     * by step, exclusive. Note that ranges that stop before they start are considered to
     * be zero-length instead of negative — if you'd like a negative range, use a negative step.
     * @see http://underscorejs.org/#range
     *
     * @param int $start
     * @param int $end
     * @param int $step
     * @return array
     */
    public static function range(int $start, int $end = null, int $step = 1): array
    {
        if ($end === null) {
            return \range(0, $start < 0 ? $start + 1 : $start - 1);
        }
        return \range($start, $end < 0 ? $end + 1  : $end - 1, $step);
    }
}
