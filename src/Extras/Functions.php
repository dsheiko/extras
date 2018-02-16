<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;
use \Closure;

/**
 * Class represents type Function
 * where function is a callable
 */
class Functions extends AbstractExtras
{

    // JAVASCRIPT INSPIRED METHODS

    /**
     * Creates a new function that, when called, has its this keyword set to the provided value,
     * with a given sequence of arguments preceding any provided when the new function is called
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind
     *
     * @param callable $target
     * @param object [$context]
     * @return callable
     */
    public static function bind(callable $target, $context = null): callable
    {
        return $context === null ? $target: Closure::bind(static::getClosure($target), $context);
    }


    /**
     * Calls a function with a given $context value and arguments provided individually.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/call
     *
     * @param callable $target
     * @param object [$context]
     * @param array [...$args]
     * @return mixed
     */
    public static function call(callable $target, $context = null, ...$args)
    {
        return static::apply($target, $context, $args);
    }

     /**
     * Calls a function with a given this value, and arguments provided as an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply
     *
     * @param callable $target
     * @param object [$context]
     * @param array [$args]
     * @return mixed
     */
    public static function apply(callable $target, $context = null, array $args = [])
    {
        return static::invoke(
            static::bind($target, $context),
            $args
        );
    }

    /**
     * Returns a string representing the source code of the function.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/toString
     *
     * @param callable $target
     * @return string
     */
    public static function toString(callable $target): string
    {
        return \ReflectionFunction::export($target, true);
    }

    /**
     * Invoke a callable with an array of parameters
     *
     * @param callable $callable
     * @param array $args
     * @return mixed
     */
    public static function invoke(callable $callable, array $args)
    {
        return call_user_func_array($callable, $args);
    }


    // UNDERSCORE.JS INSPIRED METHODS


    /**
     * Creates a version of the function that can be called no more than count times. The result of the last function
     * call is memoized and returned when count has been reached.
     * @see http://underscorejs.org/#before
     *
     * @param callable $target
     * @param int $count
     * @return mixed
     */
    public static function before(callable $target, int $count): callable
    {
        return function (...$args) use (&$count, $target) {
            static $memo = null;
            if (--$count >= 0) {
                $memo = static::invoke($target, $args);
            }
            return $memo;
        };
    }

    /**
     * Creates a version of the function that will only be run after first being called count times. Please note that
     * the function shall not receive parameters.
     * @see http://underscorejs.org/#after
     *
     * @param callable $target
     * @param int $count
     * @return callable|null
     */
    public static function after(callable $target, int $count): callable
    {
        return function (...$args) use (&$count, $target) {
            if (--$count >= 0) {
                return false;
            }
            return static::invoke($target, $args);
        };
    }

    /**
     * Creates a version of the function that can only be called one time. Repeated calls to the modified function
     * will have no effect, returning the value from the original call. Useful for initialization functions, instead
     * of having to set a boolean flag and then check it later.
     * @see http://underscorejs.org/#once
     *
     * @param callable $target
     * @return mixed
     */
    public static function once(callable $target): callable
    {
        return static::before($target, 1);
    }

    /**
     * Creates and returns a new, throttled version of the passed function, that, when invoked repeatedly,
     * will only actually call the original function at most once per every wait milliseconds.
     *
     * @param callable $target
     * @param int $wait
     */
    public static function throttle(callable $target, int $wait): callable
    {
        return function () use ($target, $wait) {
            static $pretime = null;
            $curtime = microtime(true);
            if (!$pretime || ($curtime - $pretime) >= ($wait / 1000)) {
                $pretime = $curtime;
                return $target();
            }
            return false;
        };
    }

    /**
     * Memoizes a given function by caching the computed result. Useful for speeding up slow-running computations.
     * If passed an optional hashFunction
     *
     * @staticvar array $cache
     * @param callable $target
     * @param callable [$hasher]
     * @return callable
     */
    public static function memoize(callable $target, $hasher = null): callable
    {
        static $cache = [];
        $hasher = $hasher ?: function ($target, array $args) {
            return md5(serialize($target) . serialize($args));
        };
        return function (...$args) use ($target, $hasher, &$cache) {
            $hash = $hasher($target, $args);
            if (!isset($cache[$hash])) {
                $cache[$hash] = static::invoke($target, $args);
            }
            return $cache[$hash];
        };
    }

    /**
     * Returns a new negated version of the predicate function ($target).
     *
     * @param callable $target
     * @return callable
     */
    public static function negate(callable $target): callable
    {
        return function (...$args) use ($target) {
            return !$target(...$args);
        };
    }

    /**
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        if (!static::isFunction($target)) {
            throw new \InvalidArgumentException("Target must be a callable; '" . gettype($target) . "' type given");
        }
        return parent::chain($target);
    }

    // OTHER METHODS

    /**
     * Obtain a closure from callable

     * @param callable $target
     * @return Closure
     */
    public static function getClosure(callable $target): Closure
    {
        return Closure::fromCallable($target);
    }



    /**
     * Test if target a callable
     * @param mixed $target
     * @return bool
     */
    public static function isFunction($target)
    {
        return is_callable($target);
    }
}
