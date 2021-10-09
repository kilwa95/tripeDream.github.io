<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pays;


class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        for ($i = 0; $i < 10; $i++) {
            $pays = new Pays();
            $pays->setName($faker->country());
            $manager->persist($pays);
        }

        $manager->flush();
    }
}
