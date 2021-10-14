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
        
        // Generate 3 users with specifica email
        $type = ['admin', 'agence', 'user'];
        for ($i = 0; $i < 3; $i++) {

            $user = new User();
            $user->setEmail($type[$i].'@'.$type[$i].'.com');
            $user->setUsername($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setAdresse($adresses[array_rand($adresses)]);
            if ($i == 0)
                $role = "ADMIN";
            elseif ($i == 1)
                $role = "AGENCE";
            elseif ($i == 2)
                $role = "USER";
            $roles = ['ROLE_'.$role ];
            $user->setRoles($roles);

            $normalUserPwd = $this->encoder->encodePassword($user, $type[$i]);
            $encodedPassword =  $normalUserPwd;
            $user->setPassword($encodedPassword);
            $user->setLastLogin($faker->dateTimeBetween('-'.rand(1, 30).' days', "now"));

            if ($type[$i] !== 'user')
                $user->setSiret($faker->numberBetween(1000000000, 2147483646));

            $manager->persist($user);
        }

        for ($i = 0; $i < 20; $i++) {

            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setAdresse($adresses[array_rand($adresses)]);
            $roles = array_rand(array_flip(['ROLE_USER', 'ROLE_AGENCE', 'ROLE_ADMIN']));
            $user->setRoles(array($roles));
            $normalUserPwd = $this->encoder->encodePassword($user, 'user');
            $agencyUserPwd = $this->encoder->encodePassword($user, 'agence');
            $adminUserPwd = $this->encoder->encodePassword($user, 'admin');

            $isSimpleUser = in_array("ROLE_USER", $user->getRoles());
            $isAgencyUser = in_array("ROLE_AGENCE", $user->getRoles());
            $isAdminUser = in_array("ROLE_ADMIN", $user->getRoles());

            if ($isSimpleUser) {
                $encodedPassword =  $normalUserPwd;
            } elseif ($isAgencyUser) {
                $encodedPassword =  $agencyUserPwd;
            } elseif ($isAdminUser) {
                $encodedPassword =  $adminUserPwd;
            }

            $user->setPassword($encodedPassword);
            if (!$isSimpleUser)
                $user->setSiret($faker->numberBetween(1000000000, 2147483646));
            
            $user->setLastLogin($faker->dateTimeBetween('-'.rand(1, 30).' days', "now"));

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
