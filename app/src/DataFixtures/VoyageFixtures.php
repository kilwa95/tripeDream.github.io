<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Voyage;
use App\Entity\Activite;
use App\Entity\Pays;
use App\Entity\Saison;



class VoyageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    
     $faker = \Faker\Factory::create('fr-FR');
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

       for ($i = 0; $i < 5; $i++) {
        $voyage = new Voyage();
        $pays = new Pays();
        $pays->setName($faker->country());
        $manager->persist($pays);
        $voyage->setName($faker->name());
        $voyage->setDescription($faker->text());
        $voyage->addActivity($ski);
        $voyage->addPay($pays);
        $voyage->addSaison($hiver);
        $manager->persist($voyage);
       }

       for ($i = 0; $i < 5; $i++) {
        $voyage = new Voyage();
        $voyage->setName($faker->name());
        $voyage->setDescription($faker->text());
        $voyage->addActivity($tennis);
        $voyage->addSaison($printemps);
        $manager->persist($voyage);
       }
       for ($i = 0; $i < 5; $i++) {
        $voyage = new Voyage();
        $voyage->setName($faker->name());
        $voyage->setDescription($faker->text());
        $voyage->addActivity( $baby_foot);
        $voyage->addSaison($ete);
        $manager->persist($voyage);
       }

       for ($i = 0; $i < 80; $i++) {
        $voyage = new Voyage();
        $voyage->setName($faker->name());
        $voyage->setDescription($faker->text());;
        $manager->persist($voyage);
       }

       $manager->flush();
    }
}