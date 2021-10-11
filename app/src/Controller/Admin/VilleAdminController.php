<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/ville")
 */
class VilleAdminController extends AbstractController
{
    /**
     * @Route("/", name="ville_list")
     */
    public function index(): Response
    {
        return $this->render('admin/ville/index.html.twig', []);
    }

    /**
     * @Route("/fetch-villes", name="ville_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(ville) FROM App\Entity\Ville ville';

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

        $dql = 'SELECT ville.id, ville.name FROM App\Entity\Ville ville ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (ville.id LIKE '%".$strMainSearch."%' OR "
                ."ville.name LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY ville.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'ville.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_ville", methods={"GET"})
     */
    public function show(Ville $ville): Response
    {
        //dd($ville);
        return $this->render('admin/ville/show.html.twig', [
            'ville' => $ville,
        ]);
    }

    /**
     * @Route("/new", name="admin_ville_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $ville = new Ville();

        $form = $this->createForm(VilleType::class, $ville, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($ville);
                $em->flush();
    
                $this->addFlash('success', "La ville a été bien crée");
                
                return $this->redirectToRoute('ville_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('ville_list');
            }
        }

        return $this->render('admin/ville/new.html.twig', [
            'ville' => $ville,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_ville_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ville $ville): Response
    {
        $form = $this->createForm(VilleType::class, $ville, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "La ville a été modifié avec succès");
    
                return $this->redirectToRoute('ville_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('ville_list');
            }
        }

        return $this->render('admin/ville/edit.html.twig', [
            'ville' => $ville,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_ville", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, VilleRepository $villeRepository): Response
    {
        $ville = $villeRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($ville);
            $em->flush();
    
            $this->addFlash('success', "La ville a été supprimé avec succès");

            return $this->redirectToRoute('ville_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('ville_list');
        }
    }
}
