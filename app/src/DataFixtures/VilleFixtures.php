<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ville;


class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        for ($i=0; $i<10; $i++) {
            $ville = new Ville();
            $ville->setName($faker->city());
            $manager->persist($ville);
        }

        $manager->flush();
    }
}
