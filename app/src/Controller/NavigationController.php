<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;


class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="navigation")
     */
    public function index(ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $activites = $activiteRepository->findAll();
        $pays = $PaysRepository->findAll();
        $saison= $SaisonRepository->findAll();

        return $this->render('navigation/index.html.twig',[
            'activites' => $activites,
            'pays' => $pays,
            'saison' =>  $saison
        ]);
    }
}
