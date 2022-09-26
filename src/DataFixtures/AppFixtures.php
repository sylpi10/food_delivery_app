<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use App\Entity\MenuItem;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 12; $i++) {
            # code...
            $resto = new Restaurant();
            $resto->setName($faker->name());
            $resto->setDescription($faker->text());
            $resto->setAddress($faker->address());
            $resto->setCity($faker->city());
            $manager->persist($resto);

            $menuitem = new MenuItem();
            $menuitem->setName($faker->name());
            $menuitem->setDescription($faker->text());
            $manager->persist($menuitem);

            $menu = new Menu();
            $menu->setName($faker->name());
            $menu->setDescription($faker->text());
            $menu->setPrice($faker->randomFloat());
            $menu->setRestaurant($resto);
            $manager->persist($menu);
        }

        $manager->flush();
    }
}
