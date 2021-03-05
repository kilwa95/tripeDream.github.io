<?php

namespace App\Controller\Front;

use App\Entity\InfoPratique;
use App\Entity\Programme;
use App\Entity\Tarif;
use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Entity\Pays;
use App\Entity\Activite;
use App\Entity\Saison;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\VoyageRepository;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
use App\Repository\FavorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/voyage")
 */
class VoyageController extends AbstractController
{
    /**
     * @Route("/", name="voyage_index", methods={"GET"})
     */
    public function index(Request $request,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository,FavorieRepository $favorieRepository, PaginatorInterface $paginator)
    {
        $voyages = $voyageRepository->findAll();
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        3/*limit per page*/
   );

        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );

        return $this->render('Front/voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyageRepository->findAll(),
            // 'favories' => $favorieRepository->findAll()
            
        ]);
    }

    /**
     * @Route("/pays/{id}", name="pays_name", methods={"GET"})
     */
    public function paysById(Pays $pays,Request $request,FavorieRepository $favorieRepository,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages = $pays->getVoyages();
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );


        return $this->render('Front/voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
        ]);
    }

     /**
     * @Route("/activite/{id}", name="activite_name", methods={"GET"})
     */
    public function activiteById(Activite $activite ,Request $request,FavorieRepository $favorieRepository,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages  =  $activite->getVoyages();
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );


        return $this->render('Front/voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
        ]);
    }

     /**
     * @Route("/saison/{id}", name="saison_name", methods={"GET"})
     */
    public function saisonById(Saison $saison, Request $request,FavorieRepository $favorieRepository,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages  =  $saison->getVoyages();
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );


        return $this->render('Front/voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
        ]);
    }

    /**
     * 
     * @Route("/{id}", name="voyage_show", methods={"GET","POST"})
     */
    public function show(Request $request,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository,FavorieRepository $favorieRepository,Voyage $voyage): Response
    {
        $isfavorie = false;
        if($this->getUser()){
            $favories = $this->getUser()->getFavorie();
            $isfavorie = false;
           
            foreach($favories as $favorie){
                $voyage_favorie = $favorie->getVoyage();
                if( $voyage_favorie->getId()==$voyage->getId() ){
                    $isfavorie = true;
                }
            }
        }
        

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setUser($this->getUser());
            $avis->setVoyage($voyage);        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avis);
            $entityManager->flush();

            return $this->redirectToRoute('voyage_show', ['id' => $voyage->getId()]);
        }

        return $this->render('Front/voyage/show.html.twig', [
            'voyage' => $voyage,
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
            'avis' => $voyage->getAvis(),
            'infosPratiques' => $voyage->getInfoPratique(),
            'programme' => $voyage->getProgramme(),
            'tarifs'  => $voyage->getTarif(),
            'isfavorie' =>  $isfavorie,
            'form' => $form->createView(),
            
        ]);
    }
}