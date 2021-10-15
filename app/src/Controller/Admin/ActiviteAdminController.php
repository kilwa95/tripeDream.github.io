<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/activite")
 */
class ActiviteAdminController extends AbstractController
{
    /**
     * @Route("/", name="activite_list")
     */
    public function index(): Response
    {
        return $this->render('admin/activite/index.html.twig', []);
    }

    /**
     * @Route("/fetch-activites", name="activite_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(activite) FROM App\Entity\Activite activite';

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

        $dql = 'SELECT activite.id, activite.name FROM App\Entity\Activite activite ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (activite.id LIKE '%".$strMainSearch."%' OR "
                ."activite.name LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY activite.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'activite.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_activite", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        //dd($activite);
        return $this->render('admin/activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @Route("/new", name="admin_activite_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $activite = new Activite();

        $form = $this->createForm(ActiviteType::class, $activite, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($activite);
                $em->flush();
    
                $this->addFlash('success', "L'activité a été bien crée");
                
                return $this->redirectToRoute('activite_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('activite_list');
            }
        }

        return $this->render('admin/activite/new.html.twig', [
            'activite' => $activite,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "L'activité a été modifié avec succès");
    
                return $this->redirectToRoute('activite_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('activite_list');
            }
        }

        return $this->render('admin/activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_activite", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, ActiviteRepository $activiteRepository): Response
    {
        $activite = $activiteRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($activite);
            $em->flush();
    
            $this->addFlash('success', "L'activité a été supprimé avec succès");

            return $this->redirectToRoute('activite_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('activite_list');
        }
    }
}
