<?php
namespace Dsheiko\Extras\Lib;

use Dsheiko\Extras\Lib\Chain;
use Dsheiko\Extras\{Arrays, Collections, Strings, Functions};

abstract class AbstractExtras
{
    /**
     * Start chain
     *
     * @param mixed $value
     * @return Chain
     */
    public static function chain($value)
    {
        switch (true) {
            case is_array($value):
                return new Chain(Arrays::class, $value);
            case is_string($value):
                return new Chain(Strings::class, $value);
            case $value instanceof \ArrayObject:
            case $value instanceof \ArrayIterator:
            case $value instanceof \Traversable:
                return new Chain(Collections::class, $value);
            case is_callable($value):
                return new Chain(Functions::class, $value);
        }

        throw new \InvalidArgumentException("Cannot find passing collection for given type");
    }
}
