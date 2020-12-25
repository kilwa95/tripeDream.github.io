<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tarif;
use App\Entity\Voyage;



class TarifFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');
        $voyages = $manager->getRepository(Voyage::class)->findAll();

        for ($i=0; $i<10; $i++) {
            $tarif  = new Tarif();
            $tarif->setPrix($faker->randomNumber(3));
            $tarif->setDepart($faker->dateTime());
            $tarif->setArrive($faker->dateTime());
            $tarif->setCapacite($faker->randomNumber(1));
            $tarif->setVoyage($voyages[array_rand($voyages)]);
            $manager->persist($tarif);

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
