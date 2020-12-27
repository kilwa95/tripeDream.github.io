<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Saison;


class SaisonFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $saisons = [
            ['name' => 'hiver'],
            ['name' => 'ete'],
            ['name' => 'printemps'],
            ['name' => 'autome'],
        ];
        foreach ( $saisons as  $item ){
            $saison = new Saison();
            $saison->setName($item['name']);
            $manager->persist($saison);
        }
        $manager->flush();

    }
}
