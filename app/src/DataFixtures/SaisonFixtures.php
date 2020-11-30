<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Saison;


class SaisonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $hiver = new Saison();
        $printemps = new Saison();
        $automne= new Saison();
        $ete = new Saison();

        $hiver->setName('hiver');
        $printemps->setName('printemps');
        $automne->setName('automne');
        $ete ->setName('ete');


        $manager->persist($hiver);
        $manager->persist($printemps);
        $manager->persist($automne);
        $manager->persist($ete);
        $manager->flush();
    }
}
