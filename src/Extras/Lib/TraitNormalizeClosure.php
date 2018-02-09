<?php
namespace Dsheiko\Extras\Lib;

use Closure;

trait TraitNormalizeClosure
{
    /**
     * Check if a supplied value is a closure
     * @param string|callable|Closure $callable
     * @return bool
     */
    public static function isClosure($callable)
    {
        return is_object($callable) && ($callable instanceof Closure);
    }

    /**
     * Obtain a closure from callable
     *
     * @example
     * static::getClosure(function() {});
     * static::getClosure("\var_dump");
     * static::getClosure([$this, "foo"]);
     *
     * @param string|callable|Closure $callable
     * @return Closure
     */
    protected static function getClosure($callable): Closure
    {
        if (!method_exists("\Closure", "fromCallable")) {
            return $callable;
        }
        return static::isClosure($callable) ? $callable : Closure::fromCallable($callable);
    }
}
