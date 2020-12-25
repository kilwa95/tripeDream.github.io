<?php

namespace App\Controller;

use App\Entity\Favorie;
use App\Form\FavorieType;
use App\Repository\FavorieRepository;
use App\Repository\VoyageRepository;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favorie")
 */
class FavorieController extends AbstractController
{
    /**
     * @Route("/", name="favorie_index", methods={"GET"})
     */
    public function index(FavorieRepository $favorieRepository, VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $favories = $favorieRepository->findAll();
        $ids = [];
        $voyages = [];
        foreach($favories as $favorie){
            $id =  $favorie->getIdVoyage();
            array_push($ids,$id);
        }

        foreach($ids as $id){
         $voyage = $voyageRepository->find($id);
         array_push($voyages,$voyage);
        }
        
        return $this->render('favorie/index.html.twig', [
            'favories' =>  $voyages,
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="favorie_new", methods={"GET","POST"})
     */
    public function new(int $id): Response
    {
        $favorie = new Favorie();
        $favorie->setIdVoyage($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($favorie);
        $entityManager->flush();
        return $this->redirectToRoute('voyage_index');

    }

    

    /**
     * @Route("/{id}", name="favorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Favorie $favorie): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$favorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favorie_index');
    }
  
}
