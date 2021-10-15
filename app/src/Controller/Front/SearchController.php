<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VoyageRepository;
use App\Repository\PaysRepository;
use App\Entity\Pays;

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

    public function searchBar(PaysRepository $paysRepository)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('dateDepart', DateType::class, [
                'label'  => "Date de départ",
                'label_attr' => ['class' => 'label'],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('duree', IntegerType::class, [
                'label'  => "Durée",
                'label_attr' => ['class' => 'label mt-3'],
            ])
            ->add('pays', EntityType::class, [
                'label'  => "Pays de destination",
                'label_attr' => ['class' => 'label mt-3'],
                'class' => Pays::class,
                'query_builder' => function (PaysRepository $paysRepository) {
                    return $paysRepository->createQueryBuilder('p');
                },
                'choice_value' => 'name',
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
        $duree = $request->request->get('form')['duree'];
        $pays = $request->request->get('form')['pays'];

        if ($depart) {
            $voyages = $repo->findByDateDepartDureePays($depart, $duree, $pays);
        }
        return $this->render('Front/search/index.html.twig', [
            'voyages' => $voyages
        ]);
    }
}
