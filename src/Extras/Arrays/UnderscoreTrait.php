<?php
namespace Dsheiko\Extras\Arrays;

use Dsheiko\Extras\Functions;
use Dsheiko\Extras\Type\PlainObject;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 */
trait UnderscoreTrait
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
     * Returns an array of a given object's own enumerable property [key, value] pairs
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries
     *
     * @param array $array
     * @return array
     */
    public static function entries(array $array): array
    {
        $pairs = [];
        static::each($array, function ($val, $key) use (&$pairs) {
            $pairs[] = [$key, $val];
        });
        return $pairs;
    }

    /**
     * Alias of entries
     *
     * @param array $array
     * @return array
     */
    public static function pairs(array $array): array
    {
        return static::entries($array);
    }

    /**
     * If the value of the named property is a function then invoke it; otherwise, return it.
     * @see http://underscorejs.org/#result
     *
     * @param array $array
     * @param string $prop
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public static function result(array $array, string $prop)
    {
        if (!isset($array[$prop])) {
            throw new \InvalidArgumentException("Array does not contain the given property");
        }
        $val = $array[$prop];
        return static::resultOf($val);
    }

    /**
     * If a supplied value is a function, call it and return the result; otherwise return the value
     * @param mixed|callable $val
     * @return mixed
     */
    private static function resultOf($val)
    {
        if (is_callable($val)) {
            return call_user_func($val);
        }
        return $val;
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
     * Look through each value in the list, returning an array of all the values that contain all of
     * the key-value pairs listed in $conditions
     * @see http://underscorejs.org/#where
     *
     * Implemented with array_intersect_assoc
     *
     * @param array $array
     * @param array $conditions
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function where(array $array, array $conditions): array
    {
        return array_intersect_assoc($array, $conditions);
    }

    /**
     * Split a collection into sets, grouped by the result of running each value through iterator
     * @see http://underscorejs.org/#groupBy
     *
     * @param array $array
     * @param callable $callable
     * @param array
     */
    public static function groupBy(array $array, callable $callable): array
    {
        return static::reduce($array, function (array $carry, $item) use ($callable) {
            $carry[$callable($item)][] = $item;
            return $carry;
        }, []);
    }

    /**
     * Sort a list into groups and return a count for the number of objects in each group.
     * @see http://underscorejs.org/#countBy
     *
     * @param array $array
     * @param callable $callable
     * @param array
     */
    public static function countBy(array $array, callable $callable): array
    {
         return static::map(static::groupBy($array, $callable), function ($item) {
            return count($item);
         });
    }

    /**
     * Return a shuffled copy of the list
     * @see http://underscorejs.org/#shuffle
     * @see http://php.net/manual/en/function.shuffle.php
     *
     * @param array $array
     * @return array
     */
    public static function shuffle(array $array): array
    {
        shuffle($array);
        return $array;
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
     * A convenient version of what is perhaps the most common use-case for map:
     * extracting a list of property values.
     * @see http://underscorejs.org/#pluck
     *
     * @param array $array
     * @param string $key
     * @return array
     */
    public static function pluck(array $array, string $key): array
    {
        return static::map($array, function ($po) use ($key) {
            $arr = static::from($po);
            return $arr[$key] ?? null;
        });
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
     * Split array into two arrays: one whose elements all satisfy predicate and one whose
     * elements all do not satisfy predicate.
     * @see http://underscorejs.org/#partition
     *
     * @param array $array
     * @param callable $callable
     * @return array
     */
    public static function partition(array $array, callable $callable): array
    {
        return [
            static::filter($array, $callable),
            static::filter($array, Functions::negate($callable))
        ];
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
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        if (!static::isArray($target)) {
            throw new \InvalidArgumentException("Target must be an array; '" . gettype($target) . "' type given");
        }
        return parent::chain($target);
    }

    /**
     * Tells you if the keys and values in properties are contained in object.
     * @see http://underscorejs.org/#isMatch
     *
     * @param array $array
     * @param array $props
     * @return bool
     */
    public static function isMatch(array $array, array $props): bool
    {
        if (empty($array)) {
            return false;
        }
        static::throwWhenNoAssocArray($array, "source array");
        static::throwWhenNoAssocArray($props, "conditions");
        return count(array_intersect_assoc($array, $props)) === count($props);
    }

    /**
     * Return a predicate function that will tell you if a passed in object contains all of
     * the key/value properties present in attrs.
     * @see http://underscorejs.org/#matcher
     *
     * @param array $props
     * @return callable
     */
    public static function matcher(array $props): callable
    {
        return function ($value) use ($props) {
            return static::isMatch($value, $props);
        };
    }

    /**
     * Looks through the list and returns the first value that matches all of the key-value
     * pairs listed in properties.
     * @see http://underscorejs.org/#findWhere
     *
     * @param array $array
     * @param array $props
     * @return array|null
     */
    public static function findWhere(array $array, array $props)
    {
        $matcher = static::matcher($props);
        return static::find($array, $matcher);
    }

    /**
     * Return the values in list without the elements that the predicate passes. The opposite of filter.
     * @see http://underscorejs.org/#reject
     *
     * @param array $array
     * @param callable $predicate
     * @return array|null
     */
    public static function reject(array $array, callable $predicate)
    {
        return static::filter($array, Functions::negate($predicate));
    }
}
