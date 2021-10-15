<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Voyage;
use App\Repository\VoyageRepository;
use App\Repository\PanierRepository;
use App\Services\Payement;
use Knp\Component\Pager\PaginatorInterface;
use SlopeIt\BreadcrumbBundle\Annotation\Breadcrumb;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/panier")
 * @Breadcrumb({
 *  { "label" = "Accueil", "route" = "navigation" }
 * })
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier_index", methods={"GET", "POST"})
     * @Breadcrumb({
     *  { "label" = "Mon panier" },
     * })
     */
    public function index(Request $request, VoyageRepository $voyageRepository, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();

        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
        $paniers = $this->getUser()->getPaniers();

        $ids = [];
        $voyages = [];
        $totale = 0;

        foreach($paniers as $panier) {
            $id =  $panier->getVoyage()->getId();
            $totale += $panier->getVoyage()->getTarif()[0]->getPrix();
            array_push($ids,$id);
        }
        foreach($ids as $id){
            $voyage = $voyageRepository->find($id);
            array_push($voyages,$voyage);
        }

        $pagination = $paginator->paginate($voyages, $request->query->getInt('page', 1), 6);
        $pagination->setParam('_fragment', 'list');

    //     if ($request->isMethod('POST')) {
    //         foreach($ids as $id){
    //           $voyage = $voyageRepository->find($id);
    //           dump( $voyage);
    //           die();
           
    //   }

        // $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache');

        $newTotal = $request->request->get('newTotal');
        
        if ($newTotal) {
            $this->get('session')->set('total', $newTotal);
            return new JsonResponse($newTotal);
        } else {
            $this->get('session')->set('total', $totale);
        }
      
        return $this->render('Front/panier/index.html.twig',[
            'paniers' => $pagination,
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
        $voyage->setStatus('reserved');
        $panier->setVoyage($voyage);
        $user = $this->getUser();
        $user->addPanier($panier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();
       
        return $this->redirectToRoute('voyage_show', ['id'=> $id]);
    }

     /**
     * @Route("/{id}", name="panier_delete", methods={"DELETE", "GET"})
     */
    public function delete(Request $request, int $id, PanierRepository $panierRepository): Response
    {  
        $user = $this->getUser();

        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        }

        $panier = $panierRepository->findOneBy(['voyage' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($panier);
        $entityManager->flush();
        
        $this->addFlash('success', "Le voyage a été supprimé de votre panier avec succès");

        return $this->redirectToRoute('panier_index');
    }
     /**
     * @Route("/validation/create-checkout-session", name="panier_validation", methods={"POST","GET"})
     * @Breadcrumb({
     *  { "label" = "Panier", "route" = "panier_index" },
     *  { "label" = "Passage commande" },
     * })
     */
    public function validate(Request $request, VoyageRepository $voyageRepository, Payement $payement): Response
    {
        $user = $this->getUser();

        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }

        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
       
        $total = $this->get('session')->get('total');
        $checkout_session = $payement->checkout($total);
        $paniers = $this->getUser()->getPaniers();
        $ids = [];
        $voyages = [];

        foreach ($paniers as $panier) {
            $id = $panier->getVoyage()->getId();
            array_push($ids, $id);
        }
        foreach ($ids as $id) {
            $voyage = $voyageRepository->find($id);
            array_push($voyages, $voyage);
        }

        if ($request->isMethod('POST')) {
            return $this->json([
              'id' => $checkout_session->id
            ]);
        }

        return $this->render('Front/payement/checkout.html.twig',[
            'paniers' => $voyages,
            'total' => $total
        ]);

    }
     /**
     * @Route("/payement/success", name="panier_success", methods={"POST","GET"})
     * @Breadcrumb({
     *  { "label" = "Panier", "route" = "panier_index" },
     *  { "label" = "Résumé commande" },
     * })
     */
    public function success(Request $request): Response
    {
        //$total = $request->get("total");
        $total = $this->get('session')->get('total');

        $user = $this->getUser();
        // if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
        //     return $this->redirectToRoute('admin');
        // }
        // if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
        //     return $this->redirectToRoute('agence_index');
        // }else{
        //     return $this->redirectToRoute('panier_index');
        // }
        $entityManager = $this->getDoctrine()->getManager();
        $paniers = $user->getPaniers();

        foreach($paniers as $panier) {
            $id=  $panier->getVoyage()->getId();
            $voyage =  $entityManager->getRepository(Voyage::class)->find($id);
            $voyage->setStatus('avaible');
            $voyage->addUsersParticipat($user);
            $entityManager->flush();
        }
        foreach($paniers as $panier) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

          
        return $this->render('Front/payement/success.html.twig',[
            //'paniers' =>  $voyages,
            'total' => $total
        ]);
    }
    
}
