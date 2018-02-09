<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\Lib\AbstractExtras;
use Dsheiko\Extras\Lib\TraitNormalizeClosure;
use Dsheiko\Extras\Lib\PlainObject;

class Arrays extends AbstractExtras
{
    use TraitNormalizeClosure;

    /**
     * JAVASCRIPT INSPIRED METHODS
     */

    /**
     * Iterate over a list of elements, yielding each in turn to an $callable function
     * @see http://underscorejs.org/#each
     *
     * Easing limitation "Only variables can be passed by reference"
     * Arrays::each([1,2,3], function(){})
     *
     * Accepts user defined / built-in functions
     * Arrays::each([1,2,3], "\\var_dump");
     *
     * Can be chained
     *
     * @param array $array
     * @param callable|string|Closure $callable
     */
    public static function each(array $array, $callable)
    {
        \array_walk($array, static::getClosure($callable));
    }

    /**
     * Produce a new array of values by mapping each value in list through a transformation function
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @return array
     */
    public static function map(array $array, $callable): array
    {
        return \array_map(static::getClosure($callable), $array);
    }

    /**
     * Boil down a list of values into a single value.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @param mixed $initial
     * @return mixed
     */
    public static function reduce(array $array, $callable, $initial = null)
    {
        return \array_reduce($array, static::getClosure($callable), $initial);
    }

    /**
     * The right-associative version of reduce.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/ReduceRight
     *
     * @param array $array
     * @param type $callable
     * @param type $initial
     * @return type
     */
    public static function reduceRight(array $array, $callable, $initial = null)
    {
        return \array_reduce(\array_reverse($array), static::getClosure($callable), $initial);
    }

    /**
     * Look through each value in the list, returning an array of all the values that pass a truth test (predicate).
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter
     *
     * @param array $array
     * @param callable|string|Closure $callable = null
     * @return array
     */
    public static function filter(array $array, $callable = null): array
    {
        if ($callable === null) {
            return \array_filter($array);
        }
        return \array_filter($array, static::getClosure($callable), \ARRAY_FILTER_USE_BOTH);
    }

    /**
     * 1) sort an array
     * @see http://php.net/manual/en/function.sort.php
     * 2) Sort an array by values using a user-defined comparison function
     * @see http://php.net/manual/en/function.usort.php
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @return array
     */
    public static function sort(array $array, $callable = null): array
    {
        if ($callable === null) {
            \sort($array);
        } else {
            \usort($array, static::getClosure($callable));
        }
        return $array;
    }

    /**
     * Return all the values of an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/values
     *
     * @param array $array
     * @return array
     */
    public static function values(array $array): array
    {
        return \array_values($array);
    }

    /**
     * Look through each value in the list, returning the first one that passes a truth test (predicate),
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/find
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @return mixed
     */
    public static function find(array $array, $callable)
    {
        $res = static::filter($array, $callable);
        return count($res) ? static::first($res) : null;
    }

    /**
     * Test whether at least one element in the array passes the test implemented by the provided function
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/some
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @return boolean
     */
    public static function some(array $array, $callable): bool
    {
        $res = static::filter($array, $callable);
        return count($res) > 0;
    }

    /**
     * Test whether all elements in the array pass the test implemented by the provided function.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/every
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @return boolean
     */
    public static function every(array $array, $callable): bool
    {
        $res = static::filter($array, $callable);
        return count($res) === count($array);
    }

    /**
     * Return all the keys or a subset of the keys of an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
     *
     * @param array $array
     * @param mixed [$searchValue]
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function keys(array $array, $searchValue = null): array
    {
        if (!static::isAssocArray($array)) {
            throw new \InvalidArgumentException("Invalid parameter 1. Must be an key-value array");
        }
        return $searchValue === null ? array_keys($array): array_keys($array, $searchValue);
    }


    /**
     * Copy the values of all properties from one or more source arrays to a target array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
     * The method works pretty much like array_merge except it treats consistently associative arrays with numeric keys
     *
     * @param array $array - target array
     * @param array ...$sources - variadic list of source arrays
     * @return array target array
     */
    public static function assign(array $array, ...$sources)
    {
        if (!static::isAssocArray($array)) {
            throw new \InvalidArgumentException("Invalid parameter 1. Must be an key-value array");
        }
        static::each($sources, function ($src, int $inx) use (&$array) {
            if (!is_array($src) || !static::isAssocArray($src)) {
                throw new \InvalidArgumentException("Invalid parameter ". ( $inx + 2 )
                    . ". Must be an key-value array");
            }
            static::each($src, function ($val, $key) use (&$array) {
                $array[$key] = $val;
            });
        });
        return $array;
    }

    /**
     * Create a new array from an array-like or iterable object
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/from
     *
     * @param mixed $list
     * @return array
     */
    public static function from($list): array
    {
        if (is_array($list)) {
            return $list;
        }
        if ($list instanceof \ArrayObject || $list instanceof \ArrayIterator) {
            return $list->getArrayCopy();
        }
        if ($list instanceof \Traversable) {
            return iterator_to_array($list, true);
        }
        return (array)$list;
    }


    /**
     * UNDERSCORE.JS INSPIRED METHODS
     */

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
     * Convert an object into a list of [key, value] pairs.
     * @see http://underscorejs.org/#pairs
     *
     * @param array $array
     * @return array
     */
    public static function pairs(array $array): array
    {
        $pairs = [];
        static::each($array, function ($val, $key) use (&$pairs) {
            $pairs[] = [$key, $val];
        });
        return $pairs;
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
     * @param callable|string|Closure $callable
     * @return mixed
     */
    public static function findIndex(array $array, $callable)
    {
        $el = static::find($array, $callable);
        return array_search($el, $array);
    }

    /**
     * Look through each value in the list, returning an array of all the values that contain all of
     * the key-value pairs listed in $conditions
     * @see http://underscorejs.org/#where
     *
     * @param array $array
     * @param array $conditions
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function where(array $array, array $conditions): array
    {
        if (!static::isAssocArray($array) || !static::isAssocArray($conditions)) {
            throw new \InvalidArgumentException("Both arguments of the method must be key-value arrays");
        }
        return array_intersect_assoc($array, $conditions);
    }

    /**
     * Split a collection into sets, grouped by the result of running each value through iterator
     * @see http://underscorejs.org/#groupBy
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @param array
     */
    public static function groupBy(array $array, $callable): array
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
     * @param callable|string|Closure $callable
     * @param array
     */
    public static function countBy(array $array, $callable): array
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
     * EXTRA METHODS
     */

    /**
     * Replace (similar to MYSQL REPLACE statement) an element matching the condition in $callback with the value
     * If no match found, add the value to the end of array
     *
     * @param array $array
     * @param callable|string|Closure $callable
     * @param mixed $element
     * @return array
     */
    public static function replace(array $array, $callable, $element): array
    {
        $inx = count($array);
        foreach ($array as $key => $val) {
            if ($callable($val)) {
                $inx = $key;
                break;
            }
        }
        $array[$inx] = $element;
        return $array;
    }

    /**
     * Test whether array is not sequential, but associative array
     * @param array $array
     * @return boolean
     */
    public static function isAssocArray(array $array): bool
    {
        if ([] === $array) {
            return false;
        }
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Convert array to a plain object
     *
     * @param array $array
     * @return PlainObject
     */
    public static function toObject(array $array): PlainObject
    {
        return new PlainObject($array);
    }
}
