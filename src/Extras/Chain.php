<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\Arrays;
use Dsheiko\Extras\Collections;
use Dsheiko\Extras\Strings;
use Dsheiko\Extras\Functions;

class Chain
{
    private $value;

    public function __construct($value = [])
    {
        $this->value = $value;
    }
    /**
     * Factory method
     *
     * @param mixed $value
     * @return \Dsheiko\Extras\Chain
     */
    public static function chain($value = [])
    {
        return new self($value);
    }

    /**
     * Return Extras class sutable for the last state of chain value
     * @param mixed $value
     * @return string
     * @throws \InvalidArgumentException
     */
    private static function guessExtrasClass($value): string
    {
        switch (true) {
            case Arrays::isArray($value):
                return Arrays::class;
            case Strings::isString($value):
                return Strings::class;
            case Collections::isCollection($value):
                return Collections::class;
            case is_callable($value):
                return Functions::class;
        }
        return "";
    }

    /**
     * Handle request for non-defined method
     *
     * @param string $name
     * @param array $args
     * @return \Dsheiko\Extras\Chain
     */
    public function __call(string $name, array $args): Chain
    {
        $class = static::guessExtrasClass($this->value);
        // Plain object to Arrays
        if (!$class && is_object($this->value)) {
            $this->value = Arrays::from($this->value);
            $class = Arrays::class;
        }
        if (!$class) {
            throw new \InvalidArgumentException("Cannot find passing collection for given type");
        }

        $call = $class . "::" . $name;
        $this->value = \call_user_func_array($call, \array_merge([$this->value], $args));
        return $this;
    }

    /**
     * Bind a middleware function (function transforms the value)
     *
     * @param callable|string|Closure $callable $function
     * @return \Dsheiko\Extras\Chain
     */
    public function middleware($callable): Chain
    {
        $function = Functions::getClosure($callable);
        $this->value = $function($this->value);
        return $this;
    }

    /**
     * Get chain results (or an element by index)
     *
     * @param int $inx
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
