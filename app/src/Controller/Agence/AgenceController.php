<?php

namespace App\Controller\Agence;

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


class AgenceController extends AbstractController
{

    /**
     * @Route("/agence", name="agence_index", methods={"GET","POST"})
     */

    public function index(){
        return $this->redirectToRoute('agence_voyage_show',['id' => $this->getUser()->getId()]); 
       }

    /**
     * @Route("/agence/new", name="voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request, VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $voyage = new Voyage();
        $programme = new Programme();
        $tarif = new Tarif();
        $voyage->addProgramme($programme);
        $voyage->addTarif($tarif);
        $voyage->setUser($this->getUser());
        $voyage->setStatus("avaible");
        $form = $this->createForm(VoyageType::class, $voyage, ['new' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyage);
            $entityManager->flush();
            $this->addFlash('success', 'Votre Voyage a etait bien crée');
            return $this->redirectToRoute('agence_voyage_show', ['id' => $this->getUser()->getId()]);
        } 

        return $this->render('agence/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    


    /**
     * @Route("/agence/user/{id}", name="agence_voyage_show", methods={"GET"})
     */
    public function show(VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $voyages = $this->getUser()->getVoyage();

        return $this->render('agence/tableVoyages.html.twig', [
            'voyages' =>  $voyages,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="trip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre Voyage a etait bien editer');
            return $this->redirectToRoute('agence_voyage_show', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('agence/new.html.twig', [
            'voyage' => $voyage,
            'operation' => 'edit',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("agence/voyage/delete/{id}", name="trip_delete", methods={"DELETE", "GET"})
     */
    public function delete(int $id, VoyageRepository $tripRepository): Response
    {
        $trip = $tripRepository->find($id);

        $programmes = $trip->getProgramme();
        $tarifs = $trip->getTarif();
        $avis = $trip->getAvis();

        foreach($programmes as $programme) {
            $trip->removeProgramme($programme);
        }
        foreach($tarifs as $tarif) {
            $trip->removeTarif($tarif);
        }
        foreach($avis as $av) {
            $trip->removeAvi($av);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($trip);

        $entityManager->flush();
        $this->addFlash('success', 'Votre Voyage a etait bien suprimé');
        return $this->redirectToRoute('agence_voyage_show', ['id' => $this->getUser()->getId()]);
    }
}
