<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\Arrays;

/**
 * Class contains Underscore utilities
 */
class Utils
{


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
     * Helper: If a supplied value is a function, call it and return the result; otherwise return the value
     * @param mixed|callable $val
     * @return mixed
     */
    public static function resultOf($val)
    {
        if (\is_callable($val)) {
            return \call_user_func($val);
        }
        return $val;
    }

    /**
     * Returns the same value that is used as the argument. In math: f(x) = x
     * This function looks useless, but is used throughout Underscore as a default iteratee.
     * @see http://underscorejs.org/#identity
     *
     * @return callable
     */
    public static function identity(): callable
    {
        return function ($value) {
            return $value;
        };
    }


     /**
     * Creates a function that returns the same value that is used as the argument of constant.
     * @see http://underscorejs.org/#constant
     *
     * @param mixed $value
     * @return mixed
     */
    public static function constant($value): callable
    {
        return function () use ($value) {
            return $value;
        };
    }

    /**
     * Returns undefined irrespective of the arguments passed to it.
     * Useful as the default for optional callback arguments.
     * @see http://underscorejs.org/#noop
     *
     * @param array ...$args (optional)
     */
    public static function noop(...$args)
    {
    }

    /**
     * Returns a random integer between min and max, inclusive.
     * If you only pass one argument, it will return a number between 0 and that number.
     * @see http://underscorejs.org/#random
     *
     * @param int $min
     * @param int $max - (optional)
     * @return type
     */
    public static function random(int $min, int $max = null)
    {
        if ($max === null) {
            return \mt_rand(0, $min);
        }
        return \mt_rand($min, $max);
    }


    /**
     * Generates a callback that can be applied to each element in a collection.
     * @see http://underscorejs.org/#iteratee
     *
     * @param callable $value
     * @param object $context (optional)
     * @return callable
     */
    public static function iteratee($value, $context = null): callable
    {
        switch (true) {
            case is_null($value):
                return Utils::identity();
            case is_array($value):
                return Arrays::matcher($value);
            case is_callable($value):
                return $context === null ? $value : \Closure::bind($value, $context);
            default:
                return Arrays::property($value);
        }
    }

    /**
     * Generate a globally-unique id for client-side models or DOM elements that need one.
     * If prefix is passed, the id will be appended to it.
     *
     * @param string $prefix
     * @return bool
     */
    public static function uniqueId(string $prefix = null): string
    {
        return $prefix === null ? \uniqid() : \uniqid($prefix);
    }

    /**
     * Return an integer timestamp for the current time, using the fastest method available in the runtime.
     * @see http://underscorejs.org/#now
     *
     * @return int
     */
    public static function now(): int
    {
        return \time();
    }
}
