<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
use App\Repository\FavorieRepository;
use Symfony\Component\HttpFoundation\Session\Session;



class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="navigation")
     */
    public function index(ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository,FavorieRepository $favorieRepository): Response
    {
        
        return $this->render('Front/navigation/index.html.twig',[
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
            // 'favories' =>  $favorieRepository->findAll()
        ]);
    }

    
}
