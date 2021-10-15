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
        $images = ['image1.jpg', 'image2.jpg', 'image3.jpg', 'image4.jpg', 'image5.jpg', 'image6.jpg',
                   'image7.jpg', 'image8.jpg', 'image9.jpg', 'image10.jpg', 'image11.jpg', 'image12.jpg',
                   'image13.jpg', 'image14.jpg', 'image15.jpg', 'image16.jpg', 'image17.jpg', 'image17.jpg',
                   'image18.jpg', 'image19.jpg', 'image20.jpg', 'image21.jpg', 'image22.jpg', 'image23.jpg',
                   'image24.jpg','image25.jpg', 'image26.jpg', 'image27.jpg', 'image28.jpg', 'image29.jpg',
                   'image30.jpg', 'image31.jpg', 'image32.jpg', 'image33.jpg', 'image34.jpg', 'image35.jpg',
                   'image36.jpg', 'image37.jpg', 'image38.jpg', 'image39.jpg', 'image40.jpg', 'image41.jpg',
                   'image42.jpg', 'image43.jpg', 'image44.jpg', 'image45.jpg', 'image46.jpg', 'image47.jpg',
                   'image48.jpg', 'image49.jpg', 'image50.jpg', 'image51.jpg', 'image52.jpg', 'image53.jpg',
                   'image54.jpg', 'image55.jpg', 'image56.jpg', 'image57.jpg', 'image58.jpg', 'image59.jpg',
                   'image60.jpg', 'image61.jpg', 'image62.jpg', 'image63.jpg', 'image64.jpg', 'image65.jpg',
                   'image66.jpg', 'image67.jpg', 'image68.jpg', 'image69.jpg', 'image70.jpg', 'image71.jpg',
                   'image72.jpg', 'image73.jpg', 'image74.jpg', 'image73.jpg', 'image74.jpg', 'image75.jpg',
                   'image78.jpg', 'image79.jpg', 'image80.jpg', 'image81.jpg', 'image82.jpg', 'image83.jpg',
                   'image84.jpg', 'image85.jpg', 'image86.jpg', 'image87.jpg', 'image88.jpg', 'image89.jpg',
                   'image90.jpg', 'image91.jpg', 'image92.jpg', 'image93.jpg', 'image94.jpg', 'image95.jpg',
                   'image96.jpg', 'image97.jpg', 'image98.jpg', 'image99.jpg', 'image100.jpg'
        ];

        foreach ($users as $user) {
            if ($user->getRoles() === ['ROLE_AGENCE'])
                array_push($usersAgencies, $user);
        }

        $infosPratiques = $manager->getRepository(InfoPratique::class)->findAll();
        $activites = $manager->getRepository(Activite::class)->findAll();
        $pays = $manager->getRepository(Pays::class)->findAll();
        $saison = $manager->getRepository(Saison::class)->findAll();
        $villes = $manager->getRepository(Ville::class)->findAll();

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
            // $voyage->setImageName($images[array_rand($images)]);
            $voyage->setImageName($images[$i]);
            $voyage->setImageSize(12345);
            $voyage->setStatus("avaible");
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