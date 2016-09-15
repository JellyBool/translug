<?php
namespace JellyBool\Translug;

use Illuminate\Support\Facades\Facade;

class TranslugFacade extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'translug';
    }
}