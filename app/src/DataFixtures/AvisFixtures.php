<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Avis;
use App\Entity\Voyage;
use App\Entity\User;


class AvisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');

        $voyages = $manager->getRepository(Voyage::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i=0; $i<1000; $i++) {
            $avis  = new Avis();
            $avis->setTitre($faker->word());
            $avis->setCompteur(rand(1,5));
            $avis->setDescription($faker->paragraph());
            $avis->setVoyage($voyages[array_rand($voyages)]);
            $avis->setUser($users[array_rand($users)]);
            $manager->persist($avis);

        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VoyageFixtures::class,
            UserFixtures::class
        ];
    }
}
