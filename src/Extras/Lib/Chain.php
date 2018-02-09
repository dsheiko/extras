<?php
namespace Dsheiko\Extras\Lib;

class Chain
{
    private $type;
    private $data;

    public function __construct(string $type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function __call($name, array $args)
    {
        $call = $this->type . "::" . $name;
        $this->data = \call_user_func_array($call, \array_merge([$this->data], $args));
        return $this;
    }

    /**
     * Get chain results (or an element by index)
     *
     * @param int $inx
     * @return mixed
     */
    public function value(int $inx = null)
    {
        return $inx === null ? $this->data : $this->data[$inx];
    }
}
