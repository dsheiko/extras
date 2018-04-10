<?php
namespace Dsheiko\Extras\Type;

use Dsheiko\Extras\Arrays;

/**
 * Object represents an associative array similar to plain object in JavaScript
 */
class PlainObject
{
    private $array = [];

    /**
     *
     * @param array|object $arrayLike
     */
    public function __construct($arrayLike = [])
    {
        $array = is_array($arrayLike) ? $arrayLike : Arrays::from($arrayLike);
        $this->array = array_map(function ($value) {
            return is_array($value) ? new self($value) : $value;
        }, $array);
    }


    /**
     * Return an array of a given object's own enumerable property [key, value] pairs
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries
     *
     * @param array $array
     * @return array
     */
    public function entries(): array
    {
        return Arrays::entries($this->array);
    }

    /**
     * Return all the values of an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/values
     *
     * @return array
     */
    public function values(): array
    {
        return Arrays::values($this->array);
    }

     /**
     * Return all the keys or a subset of the keys of an array
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
     *
     * @param mixed [$searchValue]
     * @return array
     * @throws \InvalidArgumentException
     */
    public function keys($searchValue = null): array
    {
        return Arrays::keys($this->array, $searchValue);
    }

    /**
     * Alias of entries
     *
     * @return array
     */
    public function pairs(): array
    {
        return Arrays::entries($this->array);
    }

     /**
     * Like map, but for objects. Transform the value of each property in turn.
     * @see http://underscorejs.org/#mapObject
     *
     * @param callable $iteratee
     * @param obj $context - (optional)
     * @return PlainObject
     */
    public function mapObject(callable $iteratee, $context = null): PlainObject
    {
        return new self(Arrays::mapObject($this->array, $iteratee, $context));
    }

    /**
     * Returns a copy of the object (here array) where the keys have become the values and the values the keys.
     * For this to work, all of your object's values should be unique and string serializable.
     * @see http://underscorejs.org/#invert
     *
     * @return PlainObject
     */
    public function invert(): PlainObject
    {
        return new self(Arrays::invert($this->array));
    }

     /**
     * Replica of findIndex that throws when supplied array is not associative one
     * @see http://underscorejs.org/#findKey
     *
     * @return array
     */
    public function findKey($iteratee = null, $context = null): string
    {
        return Arrays::findIndex($this->array, $iteratee, $context);
    }

    /**
     * Return a copy of the object (here array), filtered to only have values for the whitelisted keys
     * (or array of valid keys). Alternatively accepts a predicate indicating which keys to pick.
     * @see http://underscorejs.org/#pick
     *
     * @param array ...$keys
     * @return PlainObject
     */
    public function pick(...$keys): PlainObject
    {
        $args = \array_merge([$this->array], $keys);
        $array = \call_user_func_array([Arrays::class, "pick"], $args);
        return new self($array);
    }

    /**
     * Return a copy of the object (here array), filtered to omit the blacklisted keys (or array of keys).
     * Alternatively accepts a predicate indicating which keys to omit.
     * @see http://underscorejs.org/#omit
     *
     * @param array ...$keys
     * @return PlainObject
     */
    public function omit(...$keys): PlainObject
    {
        $args = \array_merge([$this->array], $keys);
        $array = \call_user_func_array([Arrays::class, "omit"], $args);
        return new self($array);
    }

    /**
     * Fill in undefined properties in object (here array) with the first value
     * present in the following list of defaults objects.
     * @see http://underscorejs.org/#defaults
     *
     * @param array $defaults
     * @return PlainObject
     */
    public function defaults(array $defaults): PlainObject
    {
         return new self(Arrays::defaults($this->array, $defaults));
    }

    /**
     * Does the object contain the given key? Alias of hasOwnProperty
     * @see http://underscorejs.org/#has
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->array);
    }

    /**
     * Returns true if an enumerable object contains no values (no enumerable own-properties).
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->array);
    }

    /**
     * Copy the values of all properties from one or more source arrays to a target array.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
     *
     * The method works pretty much like array_merge except it treats consistently
     * associative arrays with numeric keys
     *
     * @param PlainObject $target - target
     * @param array ...$sources - variadic list of source arrays
     * @return array target array
     */
    public static function assign(PlainObject $target, ...$sources): PlainObject
    {
        $sources = Arrays::map($sources, function ($src) {
            return $src instanceof PlainObject ? $src->toArray() : $src;
        });
        $target = new PlainObject(Arrays::assign($target->toArray(), ...$sources));
        return $target;
    }

    /**
     * Retrieve the source array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * Intercept $obj->property access, return corresponding array value
     *
     * @param string $prop
     * @return mixed
     */
    public function __get(string $prop)
    {
        if (\array_key_exists($prop, $this->array)) {
            return $this->array[$prop];
        }
        return null;
    }

    /**
     * Intercept $obj->property access, return true if property exists on the array
     *
     * @param string $prop
     * @return bool
     */
    public function __isset(string $prop): bool
    {
        return \array_key_exists($prop, $this->array);
    }
}
