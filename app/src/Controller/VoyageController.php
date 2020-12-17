<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
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
    ,SaisonRepository $SaisonRepository,VoyageRepository $VoyageRepository,UserRepository $UserRepository
     ,Request $request,PaginatorInterface $paginator)
    {

     $activiteId  = $request->query->get('activiteId');
     $paysId = $request->query->get('paysId');
     $saisonId = $request->query->get('saisonId');

     $voyages  = [];

     if($paysId){
       $voyages  =  $VoyageRepository->findVoyagesByPaysId($paysId);
     }

     else if($activiteId){
        $voyages  =  $VoyageRepository->findVoyagesByActivityId($activiteId);
     }

     else if($saisonId ){
        $voyages  =  $VoyageRepository->findVoyagesBySaisonId($saisonId);
     }
     else{
        $voyages = $VoyageRepository->findAll();
     }

     $pagination = $paginator->paginate(
      $voyages, /* query NOT result */
      $request->query->getInt('page', 1)/*page number*/,
      3/*limit per page*/
  );
  dump( $pagination);

        $activites = $ActiviteRepository->findAll();
        $pays = $PaysRepository->findAll();
        $saison= $SaisonRepository->findAll();
        $agences = $UserRepository->findAll();


        
        return $this->render('voyage/index.html.twig',[
            'activites' => $activites,
            'pays' => $pays,
            'saison' =>  $saison,
            'voyages' => $pagination,
            'agences' => $agences
        ]);
    }
}
