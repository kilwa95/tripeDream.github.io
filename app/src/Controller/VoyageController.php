<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
use App\Repository\VoyageRepository;
use App\Repository\UserRepository;
use App\Entity\Voyage;


class VoyageController extends AbstractController
{
    /**
     * @Route("/voyage", name="voyage")
     */
    public function index(ActiviteRepository $ActiviteRepository,PaysRepository $PaysRepository
    ,SaisonRepository $SaisonRepository,VoyageRepository $VoyageRepository,UserRepository $UserRepository ,Request $request)
    {

     $activiteId  = $request->query->get('activiteId');
     $paysId = $request->query->get('paysId');
     $voyages  = [];

     if($paysId){
       $voyages  =  $VoyageRepository->findVoyagesByPaysId($paysId);
     }

     else if($activiteId){
        $voyages  =  $VoyageRepository->findVoyagesByActivityId($activiteId);
     }
     else{
        $voyages = $VoyageRepository->findAll();
     }

        $activites = $ActiviteRepository->findAll();
        $pays = $PaysRepository->findAll();
        $saison= $SaisonRepository->findAll();
        $agences = $UserRepository->findAll();


        
        return $this->render('voyage/index.html.twig',[
            'activites' => $activites,
            'pays' => $pays,
            'saison' =>  $saison,
            'voyages' => $voyages,
            'agences' => $agences
        ]);
    }
}
