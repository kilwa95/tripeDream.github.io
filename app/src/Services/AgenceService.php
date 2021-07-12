<?php

namespace App\Services;
use App\Entity\Voyage;


class AgenceService {

    public function addNewVoyage($user){
        $voyage = new Voyage();
        $voyage->setUser($user);
        $programme = new Programme();
        $programme->setJour(4);
        $programme->setDescription('lorem ipsum lorem ipsum');


    }
}