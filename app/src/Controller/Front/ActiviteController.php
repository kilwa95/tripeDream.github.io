<?php

namespace App\Controller\Front;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/activite")
 */
class ActiviteController extends AbstractController
{
    /**
     * @Route("/", name="activite_index", methods={"GET"})
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {   
        $user = $this->getUser();
        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
        return $this->render('activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_AGENCE")
     * @Route("/new", name="activite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   
        $user = $this->getUser();
        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid() ) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activite);
            $entityManager->flush();

            return $this->redirectToRoute('activite_index');
        }

        return $this->render('Front/activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {   
        $user = $this->getUser();
        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
        return $this->render('Front/activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @IsGranted("ROLE_AGENCE")
     * @Route("/{id}/edit", name="activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite): Response
    {   
        $user = $this->getUser();
        if ($user !== null & $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        if ($user !== null & $this->isGranted('ROLE_AGENCE')) {
            return $this->redirectToRoute('agence_index');
        } 
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activite_index');
        }

        return $this->render('Front/activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activite $activite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activite_index');
    }
}
