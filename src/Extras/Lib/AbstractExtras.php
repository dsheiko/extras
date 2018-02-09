<?php
namespace Dsheiko\Extras\Lib;

use Dsheiko\Extras\Lib\Chain;

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
        $class = \get_called_class();
        return new Chain($class, $value);
    }
}
