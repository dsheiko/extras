<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\Lib\AbstractExtras;
use Dsheiko\Extras\Lib\TraitNormalizeClosure;

class Functions extends AbstractExtras
{
    use TraitNormalizeClosure;
    /**
     * Creates a version of the function that can be called no more than count times. The result of the last function
     * call is memoized and returned when count has been reached.
     * @see http://underscorejs.org/#before
     *
     * @param callable|string|Closure $callable
     * @param int $count
     * @return mixed
     */
    public static function before($callable, int $count)
    {
        $function = static::getClosure($callable);
        return function (...$args) use (&$count, $function) {
            static $memo = null;
            if (--$count >= 0) {
                $memo = call_user_func_array($function, $args);
            }
            return $memo;
        };
    }

    /**
     * Creates a version of the function that will only be run after first being called count times. Please note that
     * the function shall not receive parameters.
     * @see http://underscorejs.org/#after
     *
     * @param callable|string|Closure $callable
     * @param int $count
     * @return callable|null
     */
    public static function after($callable, int $count)
    {
        $function = static::getClosure($callable);
        return function (...$args) use (&$count, $function) {
            if (--$count >= 0) {
                return false;
            }
            return call_user_func_array($function, $args);
        };
    }

    /**
     * Creates a version of the function that can only be called one time. Repeated calls to the modified function
     * will have no effect, returning the value from the original call. Useful for initialization functions, instead
     * of having to set a boolean flag and then check it later.
     * @see http://underscorejs.org/#once
     *
     * @param callable|string|Closure $callable
     * @return mixed
     */
    public static function once($callable)
    {
        $function = static::getClosure($callable);
        return static::before($function, 1);
    }

    /**
     * Creates and returns a new, throttled version of the passed function, that, when invoked repeatedly,
     * will only actually call the original function at most once per every wait milliseconds.
     *
     * @param callable|string|Closure $callable
     * @param int $wait
     */
    public static function throttle($callable, int $wait)
    {
        $function = static::getClosure($callable);
        return function () use ($function, $wait) {
            static $pretime = null;
            $curtime = microtime(true);
            if (!$pretime || ($curtime - $pretime) >= ($wait / 1000)) {
                $pretime = $curtime;
                return $function();
            }
            return false;
        };
    }
}
