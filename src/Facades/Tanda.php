<?php

namespace Alvo\Tanda\Facades;

use Illuminate\Support\Facades\Facade;

class Tanda extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alvo-tanda';
    }
}