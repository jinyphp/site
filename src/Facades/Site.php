<?php

namespace Jiny\Site\Facades;

use Illuminate\Support\Facades\Facade;

class Site extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'site';
    }
}