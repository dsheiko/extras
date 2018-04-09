<?php
namespace Dsheiko\Extras\Arrays\Underscore;

use Dsheiko\Extras\Functions;
use Dsheiko\Extras\Utils;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 * Objects
 */
trait ObjectsTrait
{

    /**
     * Given we consider here JavaScript object as associative array,
     * it is an alias of keys
     * @see http://underscorejs.org/#allKeys
     *
     * @param array $array
     * @return array
     */
    public static function allKeys(array $array): array
    {
        return static::keys($array);
    }

    /**
     * Like map, but for objects. Transform the value of each property in turn.
     * @see http://underscorejs.org/#mapObject
     *
     * @param array $array
     * @param callable $iteratee
     * @param obj $context - (optional)
     * @return array
     */
    public static function mapObject(array $array, callable $iteratee, $context = null): array
    {
        $iteratee = Utils::iteratee($iteratee, $context);
        return \array_reduce(static::keys($array), function ($carry, $key) use ($array, $iteratee) {
            $carry[$key] = $iteratee($array[$key], $key, $array);
            return $carry;
        }, []);
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
     * Returns a copy of the object (here array) where the keys have become the values and the values the keys.
     * For this to work, all of your object's values should be unique and string serializable.
     * @see http://underscorejs.org/#invert
     *
     * @param array $array
     * @return array
     */
    public static function invert(array $array): array
    {
        return \array_flip($array);
    }

    /**
     * Replica of findIndex that throws when supplied array is not associative one
     * @see http://underscorejs.org/#findKey
     *
     * @param array $array
     * @return array
     */
    public static function findKey(array $array, $iteratee = null, $context = null): string
    {
        static::throwWhenNoAssocArray($array, "source array");
        return static::findIndex($array, $iteratee, $context);
    }

    /**
     * Alias of assign
     * @see http://underscorejs.org/#extend
     *
     * @param type ...$args
     * @return array
     */
    public static function extend(... $args): array
    {
        return \call_user_func_array([self::class, "assign"], $args);
    }

    /**
     * Return a copy of the object (here array), filtered to only have values for the whitelisted keys
     * (or array of valid keys). Alternatively accepts a predicate indicating which keys to pick.
     * @see http://underscorejs.org/#pick
     *
     * @param array $array
     * @param array ...$keys
     * @return array
     */
    public static function pick(array $array, ...$keys): array
    {
        if (empty($array) || !count($keys)) {
            return $array;
        }
        $iteratee = Functions::isFunction($keys[0])
            ? Utils::iteratee($keys[0], $keys[1] ?? null)
            : function ($value, $key, $array) use ($keys) {
                return static::has($array, $key) && \in_array($key, $keys);
            };
        return \array_reduce(\array_keys($array), function ($carry, $key) use ($array, $iteratee) {
            if ($iteratee($array[$key], $key, $array)) {
                $carry[$key] = $array[$key];
            }
            return $carry;
        }, []);
    }

    /**
     * Return a copy of the object (here array), filtered to omit the blacklisted keys (or array of keys).
     * Alternatively accepts a predicate indicating which keys to omit.
     * @see http://underscorejs.org/#omit
     *
     * @param array $array
     * @param array ...$keys
     * @return array
     */
    public static function omit(array $array, ...$keys): array
    {
        if (empty($array) || !count($keys)) {
            return $array;
        }
        $iteratee = Functions::isFunction($keys[0])
            ? Utils::iteratee($keys[0], $keys[1] ?? null)
            : function ($value, $key, $array) use ($keys) {
                return static::has($array, $key) && \in_array($key, $keys);
            };
        return \array_reduce(\array_keys($array), function ($carry, $key) use ($array, $iteratee) {
            if (!$iteratee($array[$key], $key, $array)) {
                $carry[$key] = $array[$key];
            }
            return $carry;
        }, []);
    }

    /**
     * Fill in undefined properties in object (here array) with the first value
     * present in the following list of defaults objects.
     * @see http://underscorejs.org/#defaults
     *
     * @param array $array
     * @param array $defaults
     * @return array
     */
    public static function defaults(array $array, array $defaults): array
    {
        return \array_merge($defaults, $array);
    }

    /**
     * Does the object contain the given key? Alias of hasOwnProperty
     * @see http://underscorejs.org/#has
     *
     * @param array $array
     * @param string $key
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        return static::hasOwnProperty($array, $key);
    }

    /**
     * Returns a function that will itself return the key property of any passed-in object.
     * @see http://underscorejs.org/#property
     *
     * @param string $prop
     * @return callable
     */
    public static function property(string $prop): callable
    {
        return function (array $array) use ($prop) {
            return $array[$prop];
        };
    }

    /**
     * Inverse of property. Takes an object and returns a function which will return
     * the value of a provided property.
     * @see http://underscorejs.org/#propertyOf
     *
     * @param array $array
     * @return callable
     */
    public static function propertyOf(array $array): callable
    {
        return function (string $prop) use ($array) {
            return $array[$prop];
        };
    }

    /**
     * Return a predicate function that will tell you if a passed in object contains all of
     * the key/value properties present in attrs.
     * @see http://underscorejs.org/#matcher
     *
     * @param array $attrs
     * @return callable
     */
    public static function matcher(array $attrs): callable
    {
        return function ($value) use ($attrs) {
            return static::isMatch($value, $attrs);
        };
    }

    /**
     * Tells you if the keys and values in properties are contained in object.
     * @see http://underscorejs.org/#isMatch
     *
     * @param array $array
     * @param array $attrs
     * @return bool
     */
    public static function isMatch(array $array, array $attrs): bool
    {
        if (empty($array)) {
            return false;
        }
        static::throwWhenNoAssocArray($array, "source array");
        static::throwWhenNoAssocArray($attrs, "properties");
        return count(\array_intersect_assoc($array, $attrs)) === \count($attrs);
    }

    /**
     * Performs an optimized deep comparison between the two objects, to determine
     * if they should be considered equal.
     * @see http://underscorejs.org/#isEqual
     * @see https://stackoverflow.com/questions/5678959/php-check-if-two-arrays-are-equal
     *
     * @param array $array
     * @param array $target
     * @return bool
     */
    public static function isEqual(array $array, array $target): bool
    {
        return $array === $target;
    }

    /**
     * Returns true if an enumerable object contains no values (no enumerable own-properties).
     *
     * @param array $array
     * @return bool
     */
    public static function isEmpty(array $array): bool
    {
        return empty($array);
    }

    /**
     * Test if target an array
     * @see http://underscorejs.org/#isArray
     *
     * @param mixed $target
     * @return bool
     */
    public static function isArray($target): bool
    {
        return is_array($target);
    }

    /**
     * Given we consider here JavaScript object as associative array,
     * it is an alias of isAssocArray
     * @param array $array
     * @return bool
     */
    public static function isObject(array $array): bool
    {
        return static::isAssocArray($array);
    }
}
