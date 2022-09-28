<?php

namespace App\Tests\Entity;

use App\Entity\Restaurant;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testResto(): void
    {
        $resto = new Restaurant();
        $resto->setName('resto');
        $this->assertEquals('resto', $resto->getName());
    }
}
