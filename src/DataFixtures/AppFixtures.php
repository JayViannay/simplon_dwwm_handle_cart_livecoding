<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setTitle($faker->name);
            $product->setPrice($faker->randomNumber(2));
            $product->setDescription($faker->text);
            $product->setStock($faker->randomNumber(2));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
