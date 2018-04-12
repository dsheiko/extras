<?php
namespace Dsheiko\Extras\Arrays\Underscore;

use Dsheiko\Extras\Functions;
use Dsheiko\Extras\Utils;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 * Collections
 */
trait CollectionsTrait
{

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
        $matcher = static::matcher($conditions);
        return static::filter($array, $matcher);
    }


    /**
     * Helper for grouping operations
     *
     * @param callable $behavior
     * @param array $array
     * @param mixed $iteratee
     * @param obj $context - (optional)
     * @return array
     */
    protected static function group(callable $behavior, array $array, $iteratee, $context = null)
    {
        $iteratee = Utils::iteratee($iteratee, $context);
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

    /**
     * Returns the maximum value in list. If an iteratee function is provided,
     * @see http://underscorejs.org/#max
     *
     * @param array $array
     * @param mixed $iteratee
     * @param object $context
     * @return mixed
     */
    public static function max(array $array, callable $iteratee = null, $context = null)
    {
        if ($iteratee === null) {
            return \max($array);
        }
        $iteratee = Utils::iteratee($iteratee, $context);
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
     * @param mixed $iteratee
     * @param object $context
     * @return mixed
     */
    public static function min(array $array, callable $iteratee = null, $context = null)
    {
        if ($iteratee === null) {
            return \min($array);
        }
        $iteratee = Utils::iteratee($iteratee, $context);
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
     * @param mixed $iteratee
     * @param object $context
     * @return array
     */
    public static function sortBy(array $array, $iteratee, $context = null): array
    {
        $iteratee = Utils::iteratee($iteratee, $context);

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
