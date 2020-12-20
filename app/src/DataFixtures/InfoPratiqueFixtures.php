<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\infoPratique;


class InfoPratiqueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');
        for ($i=0; $i<10; $i++) {
            $infoPratique  = new InfoPratique();
            $infoPratique->setRendezVous($faker->dateTime('Y-m-d'));
            $infoPratique->setFinSejour($faker->dateTime('Y-m-d'));
            $infoPratique->setHebergement($faker->realText());
            $infoPratique->setRepas($faker->realText());
            $infoPratique->setCovid19($faker->realText());

            $manager->persist($infoPratique);

        }
;

        $manager->flush();
    }
}
