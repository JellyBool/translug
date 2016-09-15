<?php
namespace JellyBool\Translug;

class Translug
{
    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new Translation();

        return call_user_func_array([$instance, $method], $parameters);
    }
}