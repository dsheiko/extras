<?php
namespace Lib\Collections;

use Dsheiko\Extras\Lib\AbstractExtras;
use Dsheiko\Extras\Lib\TraitNormalizeClosure;

class Collections extends AbstractExtras
{
    use TraitNormalizeClosure;

    const BREAKER = "\0\0";

    /**
     * Iterates over a list of elements, yielding each in turn to an iterator function.
     *
     * @param mixed $collection
     * @param callable|string|Closure $callable
     * @return mixed
     */
    public static function each($collection, $callable)
    {
        $function = static::getClosure($callable);
        foreach ($collection as $index => $item) {
            if ($function($item, $index, $collection) === static::BREAKER) {
                break;
            }
        }
    }
}
