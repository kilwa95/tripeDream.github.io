<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tarif;
use App\Entity\Voyage;
use App\Entity\InfoPratique;

class TarifFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');
        $voyages = $manager->getRepository(Voyage::class)->findAll();

        foreach ($voyages as $voyage) {

            // First tarif
            $tarif = new Tarif();
            $tarif->setDepart($voyage->getInfoPratique()->getDepart());
            $tarif->setRetour($voyage->getInfoPratique()->getRetour());
            $dayAfter = new \DateTime($tarif->getRetour()->format('Y-m-d H:i:s').' +1 day');

            $duree = ceil($tarif->getRetour()->diff($tarif->getDepart())->format("%a"));
            $prix = $faker->numberBetween(40, 99) * $duree;

            $tarif->setPrix($prix);

            $tarif->setCapacite($faker->randomNumber(1));
            $tarif->setVoyage($voyage);
            $manager->persist($tarif);

            for ($i = 1; $i <= 9; $i++) {
                $tarif = new Tarif();
                $tarif->setPrix($faker->randomNumber(3));

                $tarif->setDepart($dayAfter);
                $tarif->setRetour(new \DateTime($tarif->getDepart()->format('Y-m-d H:i:s').' +'.rand(6, 60).' day'));
                                                
                $dayAfter = new \DateTime($tarif->getRetour()->format('Y-m-d H:i:s').' +1 day');
    
                $tarif->setCapacite($faker->randomNumber(1));
                $tarif->setVoyage($voyage);
                $manager->persist($tarif);
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
