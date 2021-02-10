<?php

namespace App\DataFixtures;

use App\Entity\Programme;
use App\Entity\User;
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
        $users = $manager->getRepository(User::class)->findAll();
        $usersAgencies = [];

        foreach ($users as $user) {
            if ($user->getRoles() === ['ROLE_AGENCE'])
                array_push($usersAgencies, $user);
        }

        $infosPratiques =  $manager->getRepository(InfoPratique::class)->findAll();
        $activites=  $manager->getRepository(Activite::class)->findAll();
        $pays =  $manager->getRepository(Pays::class)->findAll();
        $saison =  $manager->getRepository(Saison::class)->findAll();
        $villes =  $manager->getRepository(Ville::class)->findAll();

        $NB_TRIPS = 100;
        for ($i = 0, $prInd = 0; $i < $NB_TRIPS; $i++, $prInd += 7) {
            $voyage  = new Voyage();
            $voyage->setUser($usersAgencies[array_rand($usersAgencies)]);
            $voyage->setName($faker->jobTitle());
            $voyage->setInfoPratique($infosPratiques[$i]);
            $voyage->setDescription($faker->realText());
            $voyage->setPointFort($faker->realText());
            $voyage->addActivity($activites[array_rand($activites)]);
            $voyage->addPay($pays[array_rand($pays)]);
            $voyage->addSaison($saison[array_rand($saison)]);
            $voyage->addVille($villes[array_rand($villes)]);
            $manager->persist($voyage);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            InfoPratiqueFixtures::class,
            ActivityFixtures::class,
            PaysFixtures::class,
            SaisonFixtures::class,
            VilleFixtures::class,
        ];
    }
}