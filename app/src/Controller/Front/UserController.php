<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;

/**
 * @Route("/profile")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="front_user")
     */
    public function index(): Response
    {
        return $this->render('Front/profile/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id}", name="show_front_user", methods={"GET"})
     */
    public function show(User $user): Response
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('Front/profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_front_user", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(UserType::class, $user, ['action' => 'edit', 'type' => 'edit_profil_front']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $password = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);
            // $user = $form->getData();
            // dd($user);
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // $this->getDoctrine()->getManager()>flush();
                $this->addFlash('success', "L'utilisateur a été modifié avec succès (déconnexion automatique...)");
    
                return $this->redirectToRoute('app_logout');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('edit_front_user', ['id' => $user->getId()]);
            }
        }

        return $this->render('Front/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
