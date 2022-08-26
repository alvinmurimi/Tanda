<?php

namespace Alvoo\Tanda\Facades;

use Illuminate\Support\Facades\Facade;

class Tanda extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alvoo-tanda';
    }
}