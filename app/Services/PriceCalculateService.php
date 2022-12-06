<?php

namespace App\Http\Controllers;



class PriceCalculateService
{
    public function plus(array $data): int
    {
       return $data['a'] + $data['b'];
    }
}