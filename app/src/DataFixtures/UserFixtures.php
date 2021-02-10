<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Adresse;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr-FR');
        $adresses = $manager->getRepository(Adresse::class)->findAll();

        for ($i = 0; $i < 20; $i++) {

            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setAdresse($adresses[array_rand($adresses)]);
            $roles = array_rand(array_flip(['ROLE_USER', 'ROLE_AGENCE']));
            $user->setRoles(array($roles));
            $normalUserPwd = $this->encoder->encodePassword($user, 'user');
            $agencyUserPwd = $this->encoder->encodePassword($user, 'agence');
            $isSimpleUser = in_array("ROLE_USER", $user->getRoles());
            $encodedPassword = $isSimpleUser ? $normalUserPwd : $agencyUserPwd;
            $user->setPassword($encodedPassword);
            if (!$isSimpleUser)
                $user->setSiret($faker->numberBetween(1000000000, 2147483646));

            $manager->persist($user);
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
