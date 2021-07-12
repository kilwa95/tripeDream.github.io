<?php
namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/purchase")
 */

class PurchaseController extends AbstractController {

    /**
     * @Route("/", name="purchase_index", methods={"GET"})
     */

    public function index()
        {
            return $this->render('Front/purchase/index.html.twig',[
                'purchases' => $purchases = $this->getUser()->getParticipat()
            ]);
        }

}

