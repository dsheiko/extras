<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;

/**
 * Class represents type Any
 */
class Any extends AbstractExtras
{

   /**
     * Returns true if source is an instance of DateTime.
     * @see http://underscorejs.org/#isDate
     *
     * @param mixed $source
     * @return bool
     */
    public static function isDate($source): bool
    {
        return $source instanceof \DateTime;
    }

     /**
     * Returns true if source is an Error
     * @see http://underscorejs.org/#isError
     *
     * @param mixed $source
     * @return bool
     */
    public static function isError($source): bool
    {
        return $source instanceof \Error;
    }

     /**
     * Returns true if source is an Exception
     *
     * @param mixed $source
     * @return bool
     */
    public static function isException($source): bool
    {
        return $source instanceof \Exception;
    }

    /**
     * Returns true if source is NULL
     *
     * @param mixed $source
     * @return bool
     */
    public static function isNull($source): bool
    {
        return \is_null($source);
    }
}
