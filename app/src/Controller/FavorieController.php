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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/favorie")
 */
class FavorieController extends AbstractController
{
    /**
     * @Route("/", name="favorie_index", methods={"GET"})
     */
    public function index(VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $favories = $this->getUser()->getFavorie();
        $ids = [];
        $voyages = [];

        foreach($favories as $favorie) {
            $id=  $favorie->getVoyage()->getId();
            array_push($ids,$id);
        }
        foreach($ids as $id){
            $voyage = $voyageRepository->find($id);
            array_push($voyages,$voyage);
        }

        return $this->render('favorie/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
            'favories' =>  $voyages,
        ]);
    }

    /**
     * @Route("/new/{id}", name="favorie_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(int $id, VoyageRepository $voyageRepository): Response
    {
        $favorie = new Favorie();
        $voyage = $voyageRepository->find($id);
        $favorie->setVoyage($voyage);
        $user = $this->getUser();
        $user->addFavorie( $favorie);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($favorie);
        $entityManager->flush();
       
        return $this->redirectToRoute('voyage_show', ['id'=> $id]);

    }
    
    /**
     * @Route("/{id}", name="favorie_delete", methods={"DELETE","GET"})
     */
    public function delete(int $id, FavorieRepository $favorieRepository): Response
    {
        $favorie = $favorieRepository->findOneBy(['voyage' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($favorie);
        $entityManager->flush();

        return $this->redirectToRoute('voyage_show', ['id'=> $id]);
    }
}
