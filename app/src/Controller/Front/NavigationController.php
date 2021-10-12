<?php

namespace App\Controller\Front;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoyageRepository;
use App\Repository\ActiviteRepository;
use App\Repository\PaysRepository;
use App\Repository\SaisonRepository;
use App\Repository\FavorieRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\UserRepository;

class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="navigation")
     */
    public function index(VoyageRepository $voyageRepository, ActiviteRepository $activiteRepository, PaysRepository $paysRepository, SaisonRepository $SaisonRepository, FavorieRepository $favorieRepository): Response
    {
        $user = $this->getUser();

        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_index');
        }

        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        }

        $voyages = $voyageRepository->findBy(['status' => 'avaible']);
        shuffle($voyages);
        $voyages = array_slice($voyages, 0, 4);

        $pays = $paysRepository->findAll();
        shuffle($pays);
        $pays = array_slice($pays, 0, 5);

        $voyagesByPays = [];

        foreach ($pays as $p) {
            $voyagesByPays[] = $voyageRepository->findByPays($p->getName());
        }

        return $this->render('Front/navigation/index.html.twig', [
            'voyages' => $voyages,
            'voyagesByPays' => $voyagesByPays,
        ]);
    }
}
