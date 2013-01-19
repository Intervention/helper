<?php

namespace Intervention\Helper\Facades;

use Illuminate\Support\Facades\Facade;

class String extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'string';
    }
}