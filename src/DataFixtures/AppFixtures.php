<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $ingredients = [];

        for ($i = 1; $i <= 50; $i++) {
            $ingredient = new Ingredient();

            $ingredient->setName($this->faker->word())
                ->setPrice($this->faker->randomFloat(2, 1, 199));

            $manager->persist($ingredient);
            $ingredients[] = $ingredient;
        }

        // RECIPES
        for ($i = 1; $i <= 20; $i++) {
            $recipe = new Recipe();

            $recipe->setName($this->faker->sentence(2))
                ->setDescription($this->faker->text(200))
                ->setTime($this->faker->numberBetween(10, 120))
                ->setNbPersons($this->faker->numberBetween(1, 6))
                ->setDifficulty($this->faker->numberBetween(1, 5))
                ->setPrice($this->faker->randomFloat(2, 5, 100))
                ->setIsFavorite($this->faker->boolean());

            $randomIngredients = $this->faker->randomElements($ingredients, 3);

            foreach ($randomIngredients as $ingredient) {
                $recipe->addIngredient($ingredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}