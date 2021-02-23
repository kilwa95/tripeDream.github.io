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
        return $this->render('agence/index.html.twig');
    }

    /**
     * @IsGranted("ROLE_AGENCE")
     * @Route("/new", name="voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request, VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $voyage = new Voyage();

        $user = $this->getUser();
        $voyage->setUser($user);

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

        $user->addVoyage($voyage);

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
            $this->addFlash('success', 'Votre Voyage a etait bien crée');

            return $this->redirectToRoute('show_my_trips', ['id' => $this->getUser()->getId()]);
        } 

        return $this->render('Front/voyage/new.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
            'operation' => 'create',
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user_id:{id}", name="show_my_trips", methods={"GET"})
     */
    public function showMyTrips(VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $myTrips = $this->getUser()->getVoyage();

        return $this->render('Front/my_trips/show.html.twig', [
            'myTrips' =>  $myTrips,
            'voyages' => $voyageRepository->findAll(),
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),
        ]);
    }


    /**
     * @IsGranted("ROLE_AGENCE")
     * @Route("/{id}/edit", name="trip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository ,ActiviteRepository $activiteRepository,PaysRepository $PaysRepository,SaisonRepository $SaisonRepository): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre Voyage a etait bien editer');
            return $this->redirectToRoute('show_my_trips', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('Front/voyage/edit.html.twig', [
            'voyages' => $voyageRepository->findAll(),
            'activites' => $activiteRepository->findAll(),
            'pays' => $PaysRepository->findAll(),
            'saison' =>  $SaisonRepository->findAll(),

            'voyage' => $voyage,
            'operation' => 'edit',
            'form' => $form->createView(),
        ]);
    }

      /**
     * @IsGranted("ROLE_AGENCE")
     * @Route("/{id}/delete", name="trip_delete", methods={"DELETE", "GET"})
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
        return $this->redirectToRoute('show_my_trips', ['id' => $this->getUser()->getId()]);
    }
}
