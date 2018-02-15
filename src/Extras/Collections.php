<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;
use Dsheiko\Extras\Arrays;
use Dsheiko\Extras\Functions;

class Collections extends AbstractExtras
{

    const BREAKER = "\0\0";

    /**
     * Iterates over a list of elements, yielding each in turn to an iterator function.
     *
     * @param mixed $collection
     * @param callable $callable
     * @return mixed
     */
    public static function each($collection, callable $callable)
    {
        foreach ($collection as $index => $item) {
            if (Functions::invoke($callable, [$item, $index, $collection]) === static::BREAKER) {
                break;
            }
        }
    }

    /**
     * Converts collection into an array
     *
     * @param mixed $collection
     * @return array
     */
    public static function toArray($collection): array
    {
        return Arrays::from($collection);
    }

    /**
     * Test if target a collection
     * @param mixed $target
     * @return bool
     */
    public static function isCollection($target): bool
    {
        return $target instanceof \ArrayObject
            || $target instanceof \ArrayIterator
            || $target instanceof \Traversable;
    }

    /**
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        if (!static::isCollection($target)) {
            throw new \InvalidArgumentException("Target must be a Collection "
                . "(ArrayObject|ArrayIterator|Traversable); '" . gettype($target) . "' type given");
        }
        return parent::chain($target);
    }
}
