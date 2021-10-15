<?php
namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use SlopeIt\BreadcrumbBundle\Annotation\Breadcrumb;

/**
 * @Route("/purchase")
 * @Breadcrumb({
 *  { "label" = "Accueil", "route" = "navigation" }
 * })
 */

class PurchaseController extends AbstractController
{
    /**
     * @Route("/", name="purchase_index", methods={"GET"})
     * @Breadcrumb({
     *  { "label" = "Mon historique" },
     * })
     */
    public function index()
    {
        return $this->render('Front/purchase/index.html.twig',[
            'purchases' => $purchases = $this->getUser()->getParticipat()
        ]);
    }

}

