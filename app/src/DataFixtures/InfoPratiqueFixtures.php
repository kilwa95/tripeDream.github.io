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

            $infoPratique->setDepart($faker->dateTimeBetween("now", '+'.rand(1, 5).' days'));
            $infoPratique->setRetour($faker->dateTimeBetween($infoPratique->getDepart(), '+'.rand(7, 60).' days'));

            $infoPratique->setHebergement($faker->realText());
            $infoPratique->setRepas($faker->realText());
            $infoPratique->setCovid19($faker->realText());

            $diff = $infoPratique->getRetour()->diff($infoPratique->getDepart())->format("%a");
            $infoPratique->setDuree(ceil($diff));

            $manager->persist($infoPratique);
        }

        $manager->flush();
    }
}
