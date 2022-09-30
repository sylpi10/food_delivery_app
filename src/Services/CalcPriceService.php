<?php

namespace App\Services;

class CalcPriceService
{
    function calcPecentage(int $price, float $percent)
    {
        return  $percent = $price * $percent;
    }

    function calcPrice(float $price, $percent)
    {
        return $percent + $price;
    }
}
