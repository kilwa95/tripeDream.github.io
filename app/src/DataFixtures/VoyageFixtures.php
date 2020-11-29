<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Voyage;



class VoyageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    
       $faker = \Faker\Factory::create('fr-FR');
       for ($i = 0; $i < 15; $i++) {
        $voyage = new Voyage();
        $voyage->setName($faker->name());
        $voyage->setDescription($faker->text());
        $manager->persist($voyage);
       }

       $manager->flush();
    }
}