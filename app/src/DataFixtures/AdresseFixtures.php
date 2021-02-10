<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Adresse;


class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        for ($i=0; $i<10; $i++) {
            $adresse  = new Adresse();
            $adresse->setRue($faker->streetName());
            $adresse->setCodePostal(75015);
            $adresse->setCompliment($faker->jobTitle());
            $adresse->setVille($faker->city());
            $manager->persist($adresse);

        }

        $manager->flush();
    }
}
