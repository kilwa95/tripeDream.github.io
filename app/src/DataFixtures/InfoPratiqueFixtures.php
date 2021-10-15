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
            $dayAfter = new \DateTime($infoPratique->getDepart()->format('Y-m-d H:i:s').' +1 day'); // to fix "0 jours" issue
            $infoPratique->setRetour($faker->dateTimeBetween($dayAfter, '+'.rand(3, 30).' days'));

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
