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
        if (array_key_exists($prop, $this->array)) {
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
        return array_key_exists($prop, $this->array);
    }
}
