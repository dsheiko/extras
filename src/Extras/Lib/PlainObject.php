<?php
namespace Dsheiko\Extras\Lib;

/**
 * Generic object representing converted array
 */
class PlainObject
{
    private $array = [];

    public function __construct(array $array = [])
    {
        $this->array = array_map(function ($value) {
            return is_array($value) ? new self($value) : $value;
        }, $array);
    }

    /**
     * Handling $obj->value access
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->array)) {
            return $this->array[$name];
        }
        return null;
    }

    /**
     *
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return array_key_exists($name, $this->array);
    }
}
