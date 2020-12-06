<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        for ($i = 0; $i < 5; $i++) {

            $agence = new User();
            $agence->setEmail($faker->email());
            $agence->setName($faker->name());
            $agence->setPrenom($faker->lastName());
            $agence->setPassword($faker->password());
            $agence->setRoles(['ROLE_USER','ROLE_AGENCE']);

            $manager->persist($agence);
           }

        $manager->flush();
    }
}
