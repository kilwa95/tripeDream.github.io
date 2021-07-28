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
        for ($i = 0; $i < 100; $i++) {
            $infoPratique  = new InfoPratique();
            $infoPratique->setRendezVous($faker->dateTimeBetween("now", '+'.rand(1, 5).' days'));
            $infoPratique->setFinSejour($faker->dateTimeBetween($infoPratique->getRendezVous(), '+'.rand(6, 60).' days'));
            $infoPratique->setHebergement($faker->realText());
            $infoPratique->setRepas($faker->realText());
            $infoPratique->setCovid19($faker->realText());

            $manager->persist($infoPratique);
        }

        $manager->flush();
    }
}
