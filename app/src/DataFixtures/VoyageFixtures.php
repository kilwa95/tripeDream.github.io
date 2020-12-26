<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Voyage;
use App\Entity\InfoPratique;
use App\Entity\Activite;
use App\Entity\Pays;
use App\Entity\Saison;
use App\Entity\Ville;




class VoyageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        $infoPratiques =  $manager->getRepository(infoPratique::class)->findAll();
        $activites=  $manager->getRepository(Activite::class)->findAll();
        $pays =  $manager->getRepository(Pays::class)->findAll();
        $saison =  $manager->getRepository(Saison::class)->findAll();
        $villes =  $manager->getRepository(Ville::class)->findAll();



        for ($i=0; $i<100; $i++) {
            $voyage  = new Voyage();
            $voyage->setName($faker->jobTitle());
            $voyage->setDescription($faker->realText());
            $voyage->setPointFort($faker->realText());
            $voyage->addActivity($activites[array_rand($activites)]);
            $voyage->addPay($pays[array_rand($pays)]);
            $voyage->addSaison($saison[array_rand($saison)]);
            $voyage->addVille($villes[array_rand($villes)]);
            // $voyage->setInfoPratique($infoPratiques[array_rand($infoPratiques)]);
            $manager->persist($voyage);

        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            InfoPratiqueFixtures::class,
            ActivityFixtures::class,
            PaysFixtures::class,
            SaisonFixtures::class,
            VilleFixtures::class,

        ];
    }
}