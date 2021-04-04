<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Repository\VoyageRepository;




/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('Front/panier/index.html.twig');
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
}
