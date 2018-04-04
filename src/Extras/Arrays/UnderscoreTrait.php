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
     * Alias of static::entries
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

    public static function has(array $array, string $key): bool
    {
        return static::hasOwnProperty($array, $key);
    }


    protected static function group(callable $behavior, array $array, $iteratee, $context = null)
    {
        $iteratee = static::cb($iteratee, $context);
        $result = [];
        static::each($array, function ($value, $index, $array) use (&$result, $behavior, $iteratee) {
            $key = $iteratee($value, $index, $array);
            $behavior($result, $value, $key);
        });
        return $result;
    }

    /**
     * Split a collection into sets, grouped by the result of running each value through iterator
     * @see http://underscorejs.org/#groupBy
     *
     * @param array $array
     * @param callable|string $iteratee
     * @param object $context
     * @param array
     */
    public static function groupBy(array $array, $iteratee, $context = null): array
    {
        return static::group(function (&$result, $value, $key) {
            if (static::has($result, $key)) {
                $result[$key][] = $value;
            } else {
                $result[$key] = [$value];
            }
        }, $array, $iteratee, $context);
    }

    /**
     * Sort a list into groups and return a count for the number of objects in each group.
     * @see http://underscorejs.org/#countBy
     *
     * @param array $array
     * @param callable|string $iteratee
     * @param object $context
     * @param array
     */
    public static function countBy(array $array, $iteratee, $context = null): array
    {
        return static::group(function (&$result, $value, $key) {
            if (static::has($result, $key)) {
                $result[$key]++;
            } else {
                $result[$key] = 1;
            }
        }, $array, $iteratee, $context);
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

    /**
     * Alias of static::includes
     * @see http://underscorejs.org/#contains
     *
     * @param array $array
     * @param mixed $searchElement
     * @param int $fromIndex (optional)
     * @return bool
     */
    public static function contains(array $array, $searchElement, int $fromIndex = null): bool
    {
        return static::includes($array, $searchElement, $fromIndex);
    }

    /**
     * Calls the method named by methodName on each value in the list. Any extra arguments passed
     * to invoke will be forwarded on to the method invocation.
     * @see http://underscorejs.org/#invoke
     *
     * @param array $array
     * @param callable $iteratee
     * @param array ...$args
     * @return array
     */
    public static function invoke(array $array, callable $iteratee, ...$args): array
    {
        return static::map($array, function ($item) use ($iteratee, $args) {
            return call_user_func_array(
                $iteratee,
                \array_merge([$item], $args)
            );
        });
    }

    public static function identity(): callable
    {
        return function ($value) {
            return $value;
        };
    }

    public static function property(string $prop): callable
    {
        return function (array $array) use ($prop) {
            return $array[$prop];
        };
    }

    /**
     * Helper: bind to a context when it's not null
     *
     * @param callable $value
     * @param object $context (optional)
     * @return callable
     */
    protected static function cb($value, $context = null): callable
    {
        switch (true) {
            case is_null($value):
                return static::identity();
            case is_array($value):
                return static::matcher($value);
            case is_callable($value):
                return $context === null ? $value : \Closure::bind($value, $context);
            default:
                return static::property($value);
        }
    }

    /**
     * Returns the maximum value in list. If an iteratee function is provided,
     * @see http://underscorejs.org/#max
     *
     * @param array $array
     * @param callable $iteratee
     * @param object $context
     * @return mixed
     */
    public static function max(array $array, callable $iteratee = null, $context = null)
    {
        if ($iteratee === null) {
            return \max($array);
        }
        $iteratee = static::cb($iteratee, $context);
        $lastComputed = -\INF;
        $result = -\INF;
        static::each($array, function ($value, $inx, $array) use ($iteratee, &$lastComputed, &$result) {
            $computed = \call_user_func($iteratee, $value, $inx, $array);
            if ($computed > $lastComputed || $computed === -\INF && $result === -\INF) {
                $result = $value;
                $lastComputed = $computed;
            }
        });
        return $result;
    }

    /**
     * Returns the minimum value in list. If an iteratee function is provided,
     * @see http://underscorejs.org/#min
     *
     * @param array $array
     * @param callable $iteratee
     * @param object $context
     * @return mixed
     */
    public static function min(array $array, callable $iteratee = null, $context = null)
    {
        if ($iteratee === null) {
            return \min($array);
        }
        $iteratee = static::cb($iteratee, $context);
        $lastComputed = \INF;
        $result = \INF;
        static::each($array, function ($value, $inx, $array) use ($iteratee, &$lastComputed, &$result) {
            $computed = \call_user_func($iteratee, $value, $inx, $array);
            if ($computed < $lastComputed || $computed === INF && $result === INF) {
                $result = $value;
                $lastComputed = $computed;
            }
        });
        return $result;
    }

    /**
     * Return a (stably) sorted copy of list, ranked in ascending order by the results of
     * running each value through iteratee. iteratee may also be the string name of the property to sort by
     * @see http://underscorejs.org/#sortBy
     *
     * @param array $array
     * @param callable|string $iteratee
     * @param object $context
     * @return array
     */
    public static function sortBy(array $array, $iteratee, $context = null): array
    {
        $iteratee = static::cb($iteratee, $context);

        $map = static::map($array, function ($value, $index, $array) use ($iteratee) {
            return [
              "value" => $value,
              "index" => $index,
              "criteria" => call_user_func($iteratee, $value, $index, $array),
            ];
        });

         $sort = static::sort($map, function ($left, $right) {
            $a = $left["criteria"];
            $b = $right["criteria"];
            if ($a !== $b) {
                return $a <=> $b;
            }
            return $left["index"] - $right["index"];
         });

        return static::pluck($sort, "value");
    }


    /**
     * Given a list, and an iteratee function that returns a key for each element in the list
     * (or a property name), returns an object with an index of each item.
     * Just like groupBy, but for when you know your keys are unique.
     * @see http://underscorejs.org/#indexBy
     *
     * @param array $array
     * @param callable|string $iteratee
     * @param object $context
     * @param array
     */
    public static function indexBy(array $array, $iteratee, $context = null): array
    {
        return static::group(function (&$result, $value, $key) {
             $result[$key] = $value;
        }, $array, $iteratee, $context);
    }

    /**
     * Produce a random sample from the list. Pass a number to return n random elements from the list.
     * Otherwise a single random item will be returned.
     * @see http://underscorejs.org/#sample
     *
     * @param array $array
     * @param int $count
     * @return mixed
     */
    public static function sample(array $array, int $count = null)
    {
        if ($count === null) {
            return \random_int(0, count($array) - 1);
        }
        return static::slice(
            static::shuffle($array),
            0,
            \max(0, $count)
        );
    }

    /**
     * Return the number of values in the list.
     * @see http://underscorejs.org/#size
     *
     * @param array $array
     * @return int
     */
    public static function size(array $array): int
    {
        return \count($array);
    }

    /**
     * Alias of static::from
     * @see http://underscorejs.org/#toArray
     *
     * @param mixed $list
     * @return array
     */
    public static function toArray($list): array
    {
        return static::from($list);
    }
}
