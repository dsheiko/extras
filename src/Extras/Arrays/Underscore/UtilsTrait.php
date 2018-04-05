<?php
namespace Dsheiko\Extras\Arrays\Underscore;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 * Utility
 */
trait UtilsTrait
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
    protected static function resultOf($val)
    {
        if (is_callable($val)) {
            return call_user_func($val);
        }
        return $val;
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
}
