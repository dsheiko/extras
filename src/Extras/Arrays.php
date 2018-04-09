<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;
use Dsheiko\Extras\Arrays\JavaScriptTrait;
use Dsheiko\Extras\Arrays\Underscore;

/**
 * Class represents type Array (both sequential and associative arrays)
 */
class Arrays extends AbstractExtras
{

    use JavaScriptTrait;
    use Underscore\ObjectsTrait;
    use Underscore\CollectionsTrait;
    use Underscore\ArraysTrait;

    /**
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        if (!static::isArray($target)) {
            throw new \InvalidArgumentException("Target must be an array; '" . gettype($target) . "' type given");
        }
        return parent::chain($target);
    }

    //  EXTRA METHODS




    /**
     * Replace (similar to MYSQL REPLACE statement) an element matching the condition in $callback with the value
     * If no match found, add the value to the end of array
     *
     * @param array $array
     * @param callable $callable
     * @param mixed $element
     * @return array
     */
    public static function replace(array $array, callable $callable, $element): array
    {
        $inx = count($array);
        foreach ($array as $key => $val) {
            if ($callable($val)) {
                $inx = $key;
                break;
            }
        }
        $array[$inx] = $element;
        return $array;
    }

    /**
     * Test whether array is not sequential, but associative array
     * @param array $array
     * @return boolean
     */
    public static function isAssocArray(array $array): bool
    {
        if ([] === $array) {
            return false;
        }
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Helper function
     * @param mixed $value
     * @param string $name
     * @throws \InvalidArgumentException
     */
    protected static function throwWhenNoAssocArray($value, string $name)
    {
        if (!static::isAssocArray($value)) {
            throw new \InvalidArgumentException("Invalid argument '{$name}'. Expecting a key-value array");
        }
    }
}
