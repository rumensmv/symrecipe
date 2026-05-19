<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($this->faker->word())
                ->setPrice($this->faker->randomFloat(2, 1, 199));
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
