<?php
/**
 * reflect a static method
 * @param string $class
 * @param string $method
 * @return callable
 */
function reflectStaticMethod($class, $method)
{
    $ref = new \ReflectionMethod($class, $method);
    $ref->setAccessible(true);

    /**
     * @param rest .. $arg1, $arg2
     *
     * @retunr mixed
     * @return mixed
     */
    return function () use ($ref) {
        return $ref->invokeArgs(null, func_get_args());
    };
}