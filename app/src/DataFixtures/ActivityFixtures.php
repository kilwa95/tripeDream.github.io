<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Activite;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        for ($i=0; $i<20; $i++) {
            $activitie  = new Activite();
            $activitie->setName($faker->jobTitle());
            $manager->persist($activitie);

        }

        $manager->flush();

    }
}
