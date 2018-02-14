<?php
namespace Dsheiko\Extras\Lib;

use Dsheiko\Extras\Chain;

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
        return new Chain($value);
    }
}
