<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Repository\VoyageRepository;
use App\Repository\PanierRepository;




/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index", methods={"GET"})
     */
    public function index(VoyageRepository $voyageRepository): Response
    {
        $paniers = $this->getUser()->getPaniers();
        $ids = [];
        $voyages = [];

        foreach($paniers as $panier) {
            $id=  $panier->getVoyage()->getId();
            array_push($ids,$id);
        }
        foreach($ids as $id){
            $voyage = $voyageRepository->find($id);
            array_push($voyages,$voyage);
        }


        return $this->render('Front/panier/index.html.twig',[
            'paniers' =>  $voyages,
        ]);
    }
    /**
     * @Route("/new/{id}", name="panier_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(int $id, VoyageRepository $voyageRepository): Response
    {
        $panier= new Panier();
        $voyage = $voyageRepository->find($id);
        $panier->setVoyage($voyage);
        $user = $this->getUser();
        $user->addPanier($panier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();
       
        return $this->redirectToRoute('voyage_show', ['id'=> $id]);
    }

     /**
     * @Route("/{id}", name="panier_delete", methods={"DELETE","GET"})
     */
    public function delete(int $id, PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->findOneBy(['voyage' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($panier);
        $entityManager->flush();

        return $this->redirectToRoute('panier_index');
    }
}
