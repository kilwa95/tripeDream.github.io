<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Activite;

class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ski = new Activite();
        $tennis = new Activite();
        $canoë = new Activite();


        
        $baby_foot = new Activite();

        $ski->setName('ski');
        $tennis->setName('tennis');
        $canoë->setName('canoë');
        $baby_foot->setName('baby_foot');


        $manager->persist($ski);
        $manager->persist($tennis);
        $manager->persist($canoë);
        $manager->persist($baby_foot);
        $manager->flush();
    }
}
