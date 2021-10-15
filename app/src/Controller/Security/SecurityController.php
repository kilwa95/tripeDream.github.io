<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $hasAccessFront = $this->isGranted('ROLE_USER');
        $hasAccessAdmin = $this->isGranted('ROLE_ADMIN');
        $hasAccessAgence = $this->isGranted('ROLE_AGENCE');

        $user = $this->getUser();

        if ($user && $hasAccessFront) {
            return $this->redirectToRoute('navigation');
        } elseif ($user && $hasAccessAdmin) {
            return $this->redirectToRoute('admin_index');
        } elseif ($user && $hasAccessAgence) {
            return $this->redirectToRoute('agence_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
