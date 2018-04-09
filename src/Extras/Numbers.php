<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;

/**
 * Class represents type Numbers
 */
class Numbers extends AbstractExtras
{

    // JAVASCRIPT INSPIRED METHODS

    /**
     * Return a string representing the Number object to the specified precision.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toPrecision
     *
     * @param float $source
     * @param int $precision
     * @return float
     */
    public static function toPrecision(float $source, int $precision = null): float
    {
        $srcString = (string)$source;
        if ($precision === null) {
            return $source;
        }
        if ($precision === 1) {
            return (float)\intval($source);
        }
        list($intString, $digString) = \explode(".", $srcString);
        return \round($source, $precision - \strlen($intString), \PHP_ROUND_HALF_UP);
    }

    /**
     * Format a number using fixed-point notation
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toFixed
     *
     * @param float $source
     * @param int $digits - (optional)
     * @return float
     */
    public static function toFixed(float $source, int $digits = 0): float
    {
        return \round($source, $digits, \PHP_ROUND_HALF_UP);
    }

    /**
     * Parse a string argument and returns an integer of the specified radix
     * (the base in mathematical numeral systems)
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/parseInt
     *
     * @param string $source
     * @param int $radix - (optional)
     * @return int
     */
    public static function parseInt(string $source, int $radix = 10)
    {
        $res = \base_convert($source, $radix, 10);
        return \filter_var($res, \FILTER_VALIDATE_INT, \FILTER_NULL_ON_FAILURE) ? \intval($res) : \NAN;
    }


    /**
     * Parse source to a float
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/parseFloat
     *
     * @param mixed $source
     * @return float|NaN
     */
    public static function parseFloat($source)
    {
        $res = \floatval($source);
        return ((int)$source === 0 && (int)$res === 0) ? \NAN : $res;

    }

    /**
     * Test if source a an integer
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isInteger
     *
     * @param mixed $source
     * @return bool
     */
    public static function isInteger($source): bool
    {
        return \is_int($source) && !static::isNaN($source);
    }

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
