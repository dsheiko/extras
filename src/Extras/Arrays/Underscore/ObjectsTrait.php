<?php
namespace Dsheiko\Extras\Arrays\Underscore;

/**
 * UNDERSCORE.JS INSPIRED METHODS
 * Objects
 */
trait ObjectsTrait
{
    /**
     * Does the object contain the given key? Alias of hasOwnProperty
     * @param array $array
     * @see http://underscorejs.org/#has
     *
     * @param string $key
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        return static::hasOwnProperty($array, $key);
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
}
