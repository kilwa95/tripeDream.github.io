<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Programme;
use App\Entity\Voyage;



class ProgrammeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');
        $voyages = $manager->getRepository(Voyage::class)->findAll();
        
        // for ($i = 0; $i < 700; $i++) {
        //     $programme  = new Programme();
        //     $programme->setJour(rand(5, 15));
        //     $programme->setDescription($faker->realText());
        //     $programme->setVoyage($voyages[array_rand($voyages)]);
        //     $manager->persist($programme);
        // }
        
        foreach ($voyages as $voyage) {
            for ($i = 1; $i <= $voyage->getInfoPratique()->getDuree(); $i++) {
                $programme  = new Programme();
                $programme->setJour($i);
                $programme->setDescription($faker->realText());
                $programme->setVoyage($voyage);
                $manager->persist($programme);
            }
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            VoyageFixtures::class,
        ];
    }
}
