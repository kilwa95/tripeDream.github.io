<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
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
    public function index(Request $request,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator)
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
            'activites' => $activiteRepository->findAll()

            
        ]);
    }

    /**
     * @Route("/pays/{id}", name="pays_name", methods={"GET"})
     */
    public function paysById(int $id,Request $request,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages  =  $voyageRepository->findVoyagesByPaysId($id);
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );

        dump( $voyages);

        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll()
        ]);
    }

     /**
     * @Route("/activite/{id}", name="activite_name", methods={"GET"})
     */
    public function activiteById(int $id,Request $request,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages  =  $voyageRepository->findVoyagesByActivityId($id);
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );

        dump( $voyages);

        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll()
        ]);
    }

     /**
     * @Route("/saison/{id}", name="saison_name", methods={"GET"})
     */
    public function saisonById(int $id,Request $request,ActiviteRepository $activiteRepository,VoyageRepository $voyageRepository,PaysRepository $paysRepository,SaisonRepository $saisonRepository, PaginatorInterface $paginator){
        $voyages  =  $voyageRepository->findVoyagesBySaisonId($id);
        $pagination = $paginator->paginate(
        $voyages, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        4/*limit per page*/
        );

        dump( $voyages);

        return $this->render('voyage/index.html.twig',[
            'voyages' => $pagination,
            'count'  => $voyages,
            'pays' => $paysRepository->findAll(),
            'saison' => $saisonRepository->findAll(),
            'activites' => $activiteRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $voyage = new Voyage();
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            $entityManager->flush();

            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_show", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
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