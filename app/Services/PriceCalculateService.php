<?php

namespace App\Services;



class PriceCalculateService
{
    public function plus(array $data): int
    {
       return $data['a'] + $data['b'];
    }
}