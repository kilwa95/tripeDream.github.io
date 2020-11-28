<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;

class VoyageController extends AbstractController
{
    /**
     * @Route("/voyage", name="voyage")
     */
    public function index(ActiviteRepository $ActiviteRepository,PaysRepository $PaysRepository
    ,SaisonRepository $SaisonRepository)
    {
        $activites = $ActiviteRepository->findAll();
        $pays = $PaysRepository->findAll();
        $saison= $SaisonRepository->findAll();

        
        return $this->render('voyage/index.html.twig',[
            'activites' => $activites,
            'pays' => $pays,
            'saison' =>  $saison
        ]);
    }
}
