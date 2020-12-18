<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('landingpage/index.html.twig');
    }

    /**
     * @Route("/dashboard", name="main_dashboard")
     */
    public function dashboard()
    {
        return $this->render('dashboard/index.html.twig');
    }

}