<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/*
* @see \App\Services\PriceCalculateService;
*/
class Price extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'price';
    }
}