<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/profile_index")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_index", methods={"GET"})
     */
    public function index(ProfileRepository $ProfileRepository): Response
    {
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [ 'user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $User, UserRepository $UserRepository): Response
    {
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('profile/index.html.twig', [
            'Users' => $UserRepository->findAll(),
            'User' => $User,
            'operation' => 'editUser',
            'form' => $form->createView(),
        ]);
    }
}
