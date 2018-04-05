<?php
namespace Dsheiko\Extras\Arrays;

use Dsheiko\Extras\Type\PlainObject;

/**
 * JAVASCRIPT INSPIRED METHODS
 */
trait JavaScriptTrait
{
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
     * @param callable $callable
     */
    public static function each(array $array, callable $callable)
    {
        \array_walk($array, function ($value, $inx) use ($array, $callable) {
            $callable($value, $inx, $array);
        });
    }

    /**
     * Produce a new array of values by mapping each value in list through a transformation function
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map
     *
     * @param array $array
     * @param callable $callable
     * @return array
     */
    public static function map(array $array, callable $callable): array
    {
        $inx = 0;
        return \array_map(function ($value) use ($array, $callable, &$inx) {
            return $callable($value, $inx++, $array);
        }, $array);
    }

    /**
     * Boil down a list of values into a single value.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce
     *
     * @param array $array
     * @param callable $callable
     * @param mixed $initial
     * @return mixed
     */
    public static function reduce(array $array, callable $callable, $initial = null)
    {
        $inx = 0;
        return \array_reduce($array, function ($carry, $value) use ($array, $callable, &$inx) {
            return $callable($carry, $value, $inx++, $array);
        }, $initial);
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
    public static function reduceRight(array $array, callable $callable, $initial = null)
    {
        $inx = 0;
        return \array_reduce(\array_reverse($array), function ($carry, $value) use ($array, $callable, &$inx) {
            return $callable($carry, $value, $inx++, $array);
        }, $initial);
    }

    /**
     * Look through each value in the list, returning an array of all the values that pass a truth test (predicate).
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter
     *
     * @param array $array
     * @param callable $callable = null
     * @return array
     */
    public static function filter(array $array, callable $callable = null): array
    {
        $matches =  ($callable === null) ?
            \array_filter($array) :
            \array_filter($array, $callable, \ARRAY_FILTER_USE_BOTH);
        return \array_values($matches);
    }

    /**
     * 1) sort an array
     * @see http://php.net/manual/en/function.sort.php
     *
     * 2) Sort an array by values using a user-defined comparison function
     * @see http://php.net/manual/en/function.usort.php
     *
     * @param array $array
     * @param callable $callable
     * @return array
     */
    public static function sort(array $array, callable $callable = null): array
    {
        if ($callable === null) {
            \sort($array);
        } else {
            \usort($array, $callable);
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
     * @param callable $callable
     * @return mixed
     */
    public static function find(array $array, callable $callable)
    {
        $res = static::filter($array, $callable);
        return count($res) ? static::first($res) : null;
    }

    /**
     * Test whether at least one element in the array passes the test implemented by the provided function
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/some
     *
     * @param array $array
     * @param callable $callable
     * @return boolean
     */
    public static function some(array $array, callable $callable): bool
    {
        $res = static::filter($array, $callable);
        return count($res) > 0;
    }

    /**
     * Test whether all elements in the array pass the test implemented by the provided function.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/every
     *
     * @param array $array
     * @param callable $callable
     * @return boolean
     */
    public static function every(array $array, callable $callable): bool
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
        return $searchValue === null ? array_keys($array): array_keys($array, $searchValue);
    }


    /**
     * Copy the values of all properties from one or more source arrays to a target array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
     *
     * The method works pretty much like array_merge except it treats consistently associative arrays with numeric keys
     *
     * @param array $array - target array
     * @param array ...$sources - variadic list of source arrays
     * @return array target array
     */
    public static function assign(array $array, ...$sources): array
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
        if ($list instanceof PlainObject) {
            return $list->toArray();
        }
        if ($list instanceof \ArrayObject || $list instanceof \ArrayIterator) {
            return $list->getArrayCopy();
        }
        if ($list instanceof \Traversable) {
            return iterator_to_array($list, true);
        }
        if (is_object($list)) {
            $ao = new \ArrayObject($list);
            return $ao->getArrayCopy();
        }
        return (array)$list;
    }


     /**
     * Return a shallow copy of a portion of an array into a new array object selected
     * from begin to end (end not included). The original array will not be modified.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/slice
     *
     * @param array $array
     * @param int $beginIndex
     * @param int $endIndex (optional)
     * @return array
     */
    public static function slice(array $array, int $beginIndex, int $endIndex = null): array
    {
        if ($endIndex === null) {
            return \array_slice($array, $beginIndex);
        }
        if ($endIndex < 0) {
            return \array_slice($array, $beginIndex, $endIndex);
        }
        return \array_slice($array, $beginIndex, $endIndex - $beginIndex);
    }

    /**
     * Change the contents of an array by removing existing elements and/or adding new elements.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/splice
     *
     * @param array $array
     * @param int $beginIndex
     * @param int $deleteCount (optional)
     * @param array ...$items (optional)
     * @return array
     */
    public static function splice(array $array, int $beginIndex, int $deleteCount = null, ...$items): array
    {
        if ($deleteCount !== null) {
            \array_splice($array, $beginIndex, $deleteCount, $items);
            return $array;
        }
        \array_splice($array, $beginIndex);
        return $array;
    }

    /**
     * Determine whether an array includes a certain element, returning true or false as appropriate.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/includes
     *
     * @param array $array
     * @param mixed $searchElement
     * @param int $fromIndex (optional)
     * @return bool
     */
    public static function includes(array $array, $searchElement, int $fromIndex = null): bool
    {
        if ($fromIndex === null) {
            return \in_array($searchElement, $array);
        }
        return \in_array(
            $searchElement,
            \array_slice($array, $fromIndex)
        );
    }

    /**
     * Merge two or more arrays
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/concat
     *
     * @param array $array
     * @param array ...$targets
     * @return array
     */
    public static function concat(array $array, array ...$targets): array
    {
        return \call_user_func_array("\\array_merge", \array_merge([$array], $targets));
    }

    /**
     * Shallow copy part of an array to another location in the same array and returns it, without modifying its size.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/copyWithin
     *
     * @param array $array
     * @param int $targetIndex
     * @param int $beginIndex (optional)
     * @param int $endIndex (optional)
     * @return array
     */
    public static function copyWithin(
        array $array,
        int $targetIndex,
        int $beginIndex = 0,
        int $endIndex = null
    ): array {
        $length = count($array);
        $chunk = static::slice($array, $beginIndex, $endIndex === null ? count($array) : $endIndex);
        return \array_slice(
            \array_merge(
                static::slice($array, 0, $targetIndex),
                $chunk,
                static::slice($array, $targetIndex + count($chunk))
            ),
            0,
            $length
        );
    }

    /**
     * Create a new array with a variable number of arguments, regardless of number or type of the arguments.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/of
     *
     * @param array ...$array
     * @return array
     */
    public static function of(...$args): array
    {
        return \array_values($args);
    }

    /**
     * Fill all the elements of an array from a start index to an end index with a static value.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/fill
     *
     * @param array $array
     * @param mixed $value
     * @param int $beginIndex (optional)
     * @param int $endIndex (optional)
     * @return array
     */
    public static function fill(array $array, $value, int $beginIndex = 0, int $endIndex = null): array
    {
        if ($endIndex === null) {
            $count = count($array) - $beginIndex;
        } else {
            $count = $endIndex - $beginIndex;
        }
        $fill = \array_fill(0, $count, $value);
        return \array_values(
            \call_user_func_array([self::class, "splice"], \array_merge([$array, $beginIndex, $count], $fill))
        );
    }

    /**
     * Return the first index at which a given element can be found in the array, or -1 if it is not present
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf
     *
     * @param array $array
     * @param mixed $searchElement
     * @param int $fromIndex
     * @return int
     */
    public static function indexOf(array $array, $searchElement, int $fromIndex = 0): int
    {
        if ($fromIndex !== 0) {
            $array = \array_slice($array, $fromIndex);
            $res = \array_search($searchElement, $array);
            if ($res === false) {
                return -1;
            }
        } else {
            $res = \array_search($searchElement, $array);
            if ($res === false) {
                return -1;
            }
        }
        return $res + $fromIndex;
    }

    /**
     * Join all elements of an array into a string and returns this string.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/join
     *
     * @param array $array
     * @param mixed $separator
     * @return array
     */
    public static function join(array $array, $separator = ","): string
    {
        return \implode((string)$separator, $array);
    }

    /**
     * Return the last index at which a given element can be found in the array, or -1 if it is not present.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/lastIndexOf
     *
     * @param array $array
     * @param type $searchElement
     * @param int $fromIndex
     * @return int
     */
    public static function lastIndexOf(array $array, $searchElement, int $fromIndex = null): int
    {
        $lastIndex = -1;
        $endIndex = $fromIndex === null ?  count($array) - 1 : $fromIndex;
        static::each($array, function ($value, $inx) use ($searchElement, &$lastIndex, $endIndex) {
            if ($value === $searchElement && $inx <= $endIndex) {
                $lastIndex = $inx;
            }
        });
        return $lastIndex;
    }

    /**
     * Remove the last element from an array and returns that element. This method changes the length of the array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/pop
     *
     * @param array $array
     * @return mixed
     */
    public static function pop(array &$array)
    {
        return \array_pop($array);
    }

    /**
     * Remove the first element from an array and returns that removed element.
     * This method changes the length of the array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/shift
     *
     * @param array $array
     * @return mixed
     */
    public static function shift(array &$array)
    {
        return \array_shift($array);
    }

    /**
     * Add one or more elements to the beginning of an array and returns the new length of the array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/unshift
     *
     * @param array $array
     * @param type $values
     * @return array
     */
    public static function unshift(array &$array, ...$values): array
    {
        static::each(static::reverse($values), function ($value) use (&$array) {
            \array_unshift($array, $value);
        });
        return $array;
    }

    /**
     * Add one or more elements to the end of an array and returns the new length of the array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/push
     *
     * @param array $array
     * @param type $value
     * @return array
     */
    public static function push(array $array, $value): array
    {
        \array_push($array, $value);
        return $array;
    }

    /**
     * Reverse an array in place. The first array element becomes the last,
     * and the last array element becomes the first.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reverse
     *
     * @param array $array
     * @return array
     */
    public static function reverse(array $array): array
    {
        return \array_reverse($array);
    }

    /**
     * Determine whether two values are the same value.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is
     *
     * @param array $array
     * @param array $arrayToCompare
     * @return bool
     */
    public static function is(array $array, array $arrayToCompare): bool
    {
        return (
            \is_array($array)
            && \is_array($arrayToCompare)
            && \count($array) == \count($arrayToCompare)
            && empty(\array_diff(
                \array_map("\serialize", $array),
                \array_map("\serialize", $arrayToCompare)
            ))
        );
    }

    /**
     * Return a boolean indicating whether the object has the specified property
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
     *
     * @param array $array
     * @param string $key
     * @return bool
     */
    public static function hasOwnProperty(array $array, string $key): bool
    {
        return \array_key_exists($key, $array);
    }
}
