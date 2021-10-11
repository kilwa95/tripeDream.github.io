<?php

namespace App\Controller\Front;
use App\Entity\User;
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

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Form\FormError;
use App\Form\EditProfileType;

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

    /**
     * @Route("profile/edit/{id}", name="users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('info', 'Modification effectué');
            return $this->render('Front/navigation/index.html.twig');
        }
        return $this->render('Front/profile/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("profil/password/edit/{id}", name="user_pass_edit",methods={"GET","POST"})
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('success', 'Mot de passe mis à jour avec succès');
                return $this->redirectToRoute('navigation');
            } else {
                $this->addFlash('danger', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('Front/profile/password-edit.html.twig');
    }


    
}
