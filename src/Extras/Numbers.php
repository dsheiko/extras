<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;

/**
 * Class represents type Numbers
 */
class Numbers extends AbstractExtras
{

    // JAVASCRIPT INSPIRED METHODS

    //isInteger
    //parseFloat()
    //parseInt()
    //toFixed - round(2.4232, 2);
    //toPrecision - https://stackoverflow.com/questions/26054674/is-there-an-equivalent-for-toprecision-in-php

    /**
     * Returns true if source is NaN.
     * @see http://underscorejs.org/#isNaN
     *
     * @param mixed $source
     * @return bool
     */
    public static function isNaN($source): bool
    {
        return \is_nan($source);
    }

    /**
     * Test if source a number
     * @see http://underscorejs.org/#isNumber
     *
     * @param mixed $source
     * @return bool
     */
    public static function isNumber($source): bool
    {
        return (\is_int($source) || \is_double($source)) && !static::isNaN($source);
    }

    /**
     * Returns true if source is a finite Number.
     * @see http://underscorejs.org/#isFinite
     *
     * @param mixed $source
     * @return bool
     */
    public static function isFinite($source): bool
    {
        return \is_finite($source);
    }
}
