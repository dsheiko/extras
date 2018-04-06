<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;
use Dsheiko\Extras\Arrays;
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
     * @param callable $source
     * @param object [$context]
     * @return callable
     */
    public static function bind(callable $source, $context = null): callable
    {
        return $context === null ? $source: Closure::bind(static::getClosure($source), $context);
    }


    /**
     * Calls a function with a given $context value and arguments provided individually.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/call
     *
     * @param callable $source
     * @param object [$context]
     * @param array [...$args]
     * @return mixed
     */
    public static function call(callable $source, $context = null, ...$args)
    {
        return static::apply($source, $context, $args);
    }

     /**
     * Calls a function with a given this value, and arguments provided as an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply
     *
     * @param callable $source
     * @param object [$context]
     * @param array [$args]
     * @return mixed
     */
    public static function apply(callable $source, $context = null, array $args = [])
    {
        return static::invoke(
            static::bind($source, $context),
            $args
        );
    }

    /**
     * Returns a string representing the source code of the function.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/toString
     *
     * @param callable $source
     * @return string
     */
    public static function toString(callable $source): string
    {
        return \ReflectionFunction::export($source, true);
    }

    /**
     * Invoke a callable with an array of parameters
     *
     * @param callable $source
     * @param array $args
     * @return mixed
     */
    public static function invoke(callable $source, array $args)
    {
        return call_user_func_array($source, $args);
    }


    // UNDERSCORE.JS INSPIRED METHODS

    /**
     * Binds a number of methods on the object, specified by methodNames, to be run in
     * the context of that object whenever they are invoked. Very handy for binding functions that
     * are going to be used as event handlers, which would otherwise be invoked
     * with a fairly useless this. methodNames are required.
     * @see http://underscorejs.org/#bindAll
     *
     * @param type $obj
     * @param type $methods
     * @return type
     */
    public static function bindAll($obj, ...$methods)
    {
        return Arrays::each($methods, function ($method) use ($obj) {
            $obj->$method = static::bind($obj->$method, $obj);
        });
    }

    /**
     * Partially apply a function by filling in any number of its arguments
     * @see http://underscorejs.org/#partial
     *
     * @param callable $source
     * @param array ...$boundArgs
     * @return type
     */
    public static function partial(callable $source, ...$boundArgs): callable
    {
        return function (...$args) use ($boundArgs, $source) {
            $newArgs = \array_merge($boundArgs, $args);
            return \call_user_func_array($source, $newArgs);
        };
    }

    /**
     * Memoizes a given function by caching the computed result. Useful for speeding up slow-running computations.
     * If passed an optional hashFunction
     *
     * @staticvar array $cache
     * @param callable $source
     * @param callable [$hasher]
     * @return callable
     */
    public static function memoize(callable $source, $hasher = null): callable
    {
        static $cache = [];
        $hasher = $hasher ?: function ($target, array $args) {
            return md5(serialize($target) . serialize($args));
        };
        return function (...$args) use ($source, $hasher, &$cache) {
            $hash = $hasher($source, $args);
            if (!isset($cache[$hash])) {
                $cache[$hash] = static::invoke($source, $args);
            }
            return $cache[$hash];
        };
    }

    /**
     * Invokes function after wait milliseconds.
     * If you pass the optional arguments, they will be forwarded on to the function when it is invoked.
     * @see http://underscorejs.org/#delay
     *
     * @param callable $source
     * @param int $wait in milliseconds
     * @param array ...$args
     * @return mixed
     */
    public static function delay(callable $source, int $wait, ...$args)
    {
        \usleep($wait * 1000);
        return \call_user_func_array($source, $args);
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
            if ($wait === 0) {
                return $target();
            }
            $curtime = microtime(true);
            if (!$pretime || ($curtime - $pretime) >= ($wait / 1000)) {
                $pretime = $curtime;
                return $target();
            }
            return false;
        };
    }

    /**
     * Creates and returns a new debounced version of the passed function which will postpone its execution
     * until after wait milliseconds have elapsed since the last time it was invoked. Useful for
     * implementing behavior that should only happen after the input has stopped arriving.
     * @see http://underscorejs.org/#debounce
     *
     * @param callable $target
     * @param int $wait
     * @return callable
     */
    public static function debounce(callable $target, int $wait): callable
    {
        $ipretime = microtime(true);
        return function () use ($target, $wait, $ipretime) {
            static $pretime = null;
            if ($wait === 0) {
                return $target();
            }
            $pretime = $pretime === null ? $ipretime : $pretime;
            $curtime = microtime(true);
            if (($curtime - $pretime) >= ($wait / 1000)) {
                $pretime = $curtime;
                return $target();
            }
            return false;
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
     * Wraps the first function inside of the wrapper function, passing it as the first
     * argument. This allows the wrapper to execute code before and after the function runs,
     * adjust the arguments, and execute it conditionally.
     * @see http://underscorejs.org/#wrap
     *
     * @param callable $source
     * @param callable $transformer
     * @return type
     */
    public static function wrap(callable $source, callable $transformer)
    {
        return static::partial($transformer, $source);
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
     * Returns the composition of a list of functions, where each function consumes the return value of
     * the function that follows. In math terms,
     * composing the functions f(), g(), and h() produces f(g(h())).
     * @see http://underscorejs.org/#compose
     *
     * @param arrays ...$functions
     * @return callable
     */
    public static function compose(...$functions): callable
    {
        return function (...$args) use ($functions) {
            $result = \call_user_func_array(\array_pop($functions), $args);
            return Arrays::reduce(\array_reverse($functions), function ($result, $func) {
                return $func($result);
            }, $result);
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
