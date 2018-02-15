<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;
use \Closure;

class Functions extends AbstractExtras
{
    /**
     * Check if a supplied value is a closure
     * @param string|callable|Closure $target
     * @return bool
     */
    public static function isClosure($target)
    {
        return is_object($target) && ($target instanceof Closure);
    }

    /**
     * Obtain a closure from callable
     *
     * @example
     * static::getClosure(function() {});
     * static::getClosure("\var_dump");
     * static::getClosure([$this, "foo"]);
     *
     * @param string|callable|Closure $target
     * @return Closure
     */
    public static function getClosure($target): Closure
    {
        try {
            if (!method_exists("\Closure", "fromCallable")) {
                return $target;
            }
            return static::isClosure($target) ? $target : Closure::fromCallable($target);
        } catch (\TypeError $e) {
            throw new \InvalidArgumentException("Target must be an callable|string|Closure; '"
                . gettype($target) . "' type given");
        }
    }

    /**
     * Creates a version of the function that can be called no more than count times. The result of the last function
     * call is memoized and returned when count has been reached.
     * @see http://underscorejs.org/#before
     *
     * @param callable|string|Closure $target
     * @param int $count
     * @return mixed
     */
    public static function before($target, int $count): callable
    {
        $closure = static::getClosure($target);
        return function (...$args) use (&$count, $closure) {
            static $memo = null;
            if (--$count >= 0) {
                $memo = call_user_func_array($closure, $args);
            }
            return $memo;
        };
    }

    /**
     * Creates a version of the function that will only be run after first being called count times. Please note that
     * the function shall not receive parameters.
     * @see http://underscorejs.org/#after
     *
     * @param callable|string|Closure $target
     * @param int $count
     * @return callable|null
     */
    public static function after($target, int $count): callable
    {
        $closure = static::getClosure($target);
        return function (...$args) use (&$count, $closure) {
            if (--$count >= 0) {
                return false;
            }
            return call_user_func_array($closure, $args);
        };
    }

    /**
     * Creates a version of the function that can only be called one time. Repeated calls to the modified function
     * will have no effect, returning the value from the original call. Useful for initialization functions, instead
     * of having to set a boolean flag and then check it later.
     * @see http://underscorejs.org/#once
     *
     * @param callable|string|Closure $target
     * @return mixed
     */
    public static function once($target): callable
    {
        $closure = static::getClosure($target);
        return static::before($closure, 1);
    }

    /**
     * Creates and returns a new, throttled version of the passed function, that, when invoked repeatedly,
     * will only actually call the original function at most once per every wait milliseconds.
     *
     * @param callable|string|Closure $target
     * @param int $wait
     */
    public static function throttle($target, int $wait): callable
    {
        $closure = static::getClosure($target);
        return function () use ($closure, $wait) {
            static $pretime = null;
            $curtime = microtime(true);
            if (!$pretime || ($curtime - $pretime) >= ($wait / 1000)) {
                $pretime = $curtime;
                return $closure();
            }
            return false;
        };
    }

    /**
     * Memoizes a given function by caching the computed result. Useful for speeding up slow-running computations.
     * If passed an optional hashFunction
     *
     * @staticvar array $cache
     * @param callable|string|Closure $target
     * @param callable|string|Closure [$hasher]
     * @return callable
     */
    public static function memoize($target, $hasher = null): callable
    {
        static $cache = [];
        $closure = static::getClosure($target);
        $hasher = $hasher ? static::getClosure($hasher) : function ($target, array $args) {
            return md5(serialize($target) . serialize($args));
        };
        return function (...$args) use ($closure, $hasher, $target, &$cache) {
            $hash = $hasher($target, $args);
            if (!isset($cache[$hash])) {
                $cache[$hash] = call_user_func_array($closure, $args);
            }
            return $cache[$hash];
        };
    }

    /**
     * Returns a new negated version of the predicate function ($target).
     *
     * @param callable|string|Closure $target
     * @return callable
     */
    public static function negate($target): callable
    {
        return function (...$args) use ($target) {
            return !$target(...$args);
        };
    }


    /**
     * Test if target a string
     * @param mixed $target
     * @return bool
     */
    public static function isString($target): bool
    {
        return is_string($target);
    }


    /**
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        return parent::chain(static::getClosure($target));
    }
}
