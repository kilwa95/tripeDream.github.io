<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Adresse;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        $adresses = $manager->getRepository(Adresse::class)->findAll();

        for ($i = 0; $i < 10; $i++) {

            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setUsername($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setAdresse($adresses[array_rand($adresses)]);
            $user->setRoles(['ROLE_USER','ROLE_VOYAGEUR']);

            $manager->persist($user);
           }

           for ($i = 0; $i < 10; $i++) {

            $agence = new User();
            $agence->setEmail($faker->email());
            $agence->setPassword($faker->password());
            $agence->setSiret($faker->randomNumber(6));
            $agence->setAdresse($adresses[array_rand($adresses)]);
            $agence->setRoles(['ROLE_USER','ROLE_AGENCE']);

            $manager->persist($agence);
           }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AdresseFixtures::class,
        ];
    }

    
}
