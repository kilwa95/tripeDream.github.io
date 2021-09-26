<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VoyageRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(): Response
    {
        return $this->render('Front/search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('dateDepart', DateType::class, [
                'label'  => "Date de départ",
                'label_attr' => ['class' => 'label'],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'button is-normal is-primary is-fullwidth'
                ]
            ])
            ->getForm();
        return $this->render('Front/search/search_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, VoyageRepository $repo)
    {
        $depart = $request->request->get('form')['dateDepart'];

        if ($depart) {
            $voyages = $repo->findVoyagesByDateDepart($depart);
        }
        return $this->render('Front/search/index.html.twig', [
            'voyages' => $voyages
        ]);
    }
}
