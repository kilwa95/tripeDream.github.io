<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Repository\UserRepository;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index(UserRepository $rep): Response
    {
        $recentLoggedUsers = $rep->getRecentLoggedUsers();

        return $this->render('admin/welcome.html.twig', [
            'recent_logged_users' => $recentLoggedUsers,
        ]);
    }

    // private function isUserOnline(User $user)
    // {
    //     $now = new \DateTime();
    //     $now->modify('-5 minutes');

    //     return $user->getLastActivity() > $now;
    // }
}
