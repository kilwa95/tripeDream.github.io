<?php

namespace App\Controller;

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
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyageRepository->findAll(),
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll(),
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


        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll(),
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


        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll(),

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


        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $voyage = new Voyage();

        $programme1 = new Programme();
        $programme1->setJour(4);
        $programme1->setDescription('lorem ipsum lorem ipsum');
        $voyage->addProgramme($programme1);

        $infoPratique = new InfoPratique();
        $infoPratique->setRendezVous(new \DateTime());
        $infoPratique->setFinSejour(new \DateTime());
        $infoPratique->setRendezVous(new \DateTime());
        $infoPratique->setHebergement('lorem ipsum');
        $infoPratique->setRepas('lorem ipsum');
        $infoPratique->setCovid19('lorem ipsum lorem ipsum');
        $voyage->setInfoPratique($infoPratique);

        $tarif1 = new Tarif();
        $tarif1->setPrix(0);
        $tarif1->setDepart(new \DateTime());
        $tarif1->setArrive(new \DateTime());
        $tarif1->setCapacite(0);
        $voyage->addTarif($tarif1);

        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            foreach ($voyage->getProgramme() as $programme) {
                $entityManager->persist($programme);
            }
            $entityManager->persist($voyage->getInfoPratique());
            foreach ($voyage->getTarif() as $tarif) {
                $entityManager->persist($tarif);
            }
            $entityManager->flush();

            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_show", methods={"GET","POST"})
     */
    public function show(Request $request,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository,FavorieRepository $favorieRepository,Voyage $voyage): Response
    {

        $favories = $this->getUser()->getFavorie();
        $isfavorie = false;

       
        foreach($favories as $favorie){
            $voyage_favorie = $favorie->getVoyage();
            if( $voyage_favorie->getId()==$voyage->getId() ){
                $isfavorie = true;
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

            return $this->redirectToRoute('voyage_show',['id' => $voyage->getId()]);
        }


 
        return $this->render('voyage/show.html.twig', [
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

    /**
     * @Route("/{id}/edit", name="voyage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyage $voyage): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Voyage $voyage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voyage_index');
    }
}