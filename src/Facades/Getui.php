<?php

namespace Cncal\Getui\Facades;

use Illuminate\Support\Facades\Facade;

class Getui extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'getui';
    }
}
