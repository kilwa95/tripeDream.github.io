<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Adresse;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/adresse")
 */
class AdresseAdminController extends AbstractController
{
    /**
     * @Route("/", name="adresse_list")
     */
    public function index(): Response
    {
        return $this->render('admin/adresse/index.html.twig', []);
    }

    /**
     * @Route("/fetch-adresses", name="adresse_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(adresse) FROM App\Entity\Adresse adresse';

        if ($request->get("rowCount") != null)
        {
            $records_per_page = $request->get("rowCount");
        }
        else
        {
            $records_per_page = 10;
        }

        if ($request->get("current") != null)
        {
            $current_page_number = $request->get("current");
        }
        else
        {
            $current_page_number = 1;
        }

        $start_from = ($current_page_number - 1) * $records_per_page;

        $dql = 'SELECT adresse.id, adresse.rue, adresse.compliment, adresse.codePostal, adresse.ville FROM App\Entity\Adresse adresse ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (adresse.id LIKE '%".$strMainSearch."%' OR "
                ."adresse.rue LIKE '%".$strMainSearch."%' OR "
                ."adresse.compliment LIKE '%".$strMainSearch."%' OR "
                ."adresse.codePostal LIKE '%".$strMainSearch."%' OR "
                ."adresse.ville LIKE '%".$strMainSearch."%') ";

            $dql .= $where;

            $dqlCount .= ' ' .$where;
        }
        $order_by = '';

        $recordsTotal = $em->createQuery($dqlCount)->getSingleScalarResult();

        if ($request->get("sort") != null && is_array($request->get("sort")))
        {
            foreach($request->get("sort") as $key => $value)
            {
                $order_by .= " $key $value, ";
            }
        }
        else
        {
            $dql .= 'ORDER BY adresse.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'adresse.'. substr($order_by, 0, -2);
            $dql .= ' ORDER BY ' . $orderBy;
        }
        
        if ($records_per_page != -1) {
            $items = $em
                ->createQuery($dql)
                ->setFirstResult($start_from)
                ->setMaxResults($records_per_page)
                ->getResult();
        } else {
            $items = $em
                ->createQuery($dql)
                ->getResult();
        }

        $data = [];
        foreach ($items as $item) {
            $data[] = $item;
        }
        
        $result = $this->json([
            'current'  => intval($request->get("current")),
            'rowCount'  => 10,
            'total'   => $recordsTotal,
            'rows'   => $data
        ]);

        //echo $result;exit;

        return $result;
    }

    /**
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_adresse", methods={"GET"})
     */
    public function show(Adresse $adresse): Response
    {
        //dd($adresse);
        return $this->render('admin/adresse/show.html.twig', [
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/new", name="admin_adresse_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $adresse = new Adresse();

        $form = $this->createForm(AdresseType::class, $adresse, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($adresse);
                $em->flush();
    
                $this->addFlash('success', "L'adresse a été bien crée");
                
                return $this->redirectToRoute('adresse_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('adresse_list');
            }
        }

        return $this->render('admin/adresse/new.html.twig', [
            'adresse' => $adresse,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_adresse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adresse $adresse): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "L'adresse a été modifié avec succès");
    
                return $this->redirectToRoute('adresse_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('adresse_list');
            }
        }

        return $this->render('admin/adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_adresse", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, AdresseRepository $adresseRepository): Response
    {
        $adresse = $adresseRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($adresse);
            $em->flush();
    
            $this->addFlash('success', "L'adresse a été supprimé avec succès");

            return $this->redirectToRoute('adresse_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('adresse_list');
        }
    }
}
