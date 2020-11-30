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

            $user = new User();
            $user->setEmail($faker->email());
            $user->setName($faker->name());
            $user->setPrenom($faker->lastName());
            $user->setPassword($faker->password());
            $user->setRoles(['ROLE_USER','ROLE_AGENCE']);

            $manager->persist($user);
           }

        $manager->flush();
    }
}
