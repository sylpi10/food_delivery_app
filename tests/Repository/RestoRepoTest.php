<?php

namespace App\Tests\Repository;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RestoRepoTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $manager = $kernel->getContainer()->get('doctrine')->getManager();
        $restorepo = $manager->getRepository(Restaurant::class);


        $lat = 0.156967;
        $lon = 45;
        /**
         * @var RestaurantRepository $restoRepo
         */
        // $this->assertSame('test', $kernel->getEnvironment());
        $restaurants = $restorepo->findByLatLon($lat, $lon);

        $this->assertCount(4, $restaurants);
    }
}
