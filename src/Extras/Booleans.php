<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;

/**
 * Class represents type Numbers
 */
class Booleans extends AbstractExtras
{
    /**
     * Returns true if source is either true or false.
     * @see http://underscorejs.org/#isBoolean
     *
     * @param mixed $source
     * @return bool
     */
    public static function isBoolean($source): bool
    {
        return \is_bool($source);
    }
}
