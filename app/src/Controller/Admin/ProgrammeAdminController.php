<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Programme;
use App\Form\ProgrammeType;
use App\Repository\ProgrammeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/programme")
 */
class ProgrammeAdminController extends AbstractController
{
    /**
     * @Route("/", name="programme_list")
     */
    public function index(): Response
    {
        return $this->render('admin/programme/index.html.twig', []);
    }

    /**
     * @Route("/fetch-programmes", name="programme_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(programme) FROM App\Entity\Programme programme';

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

        $dql = 'SELECT programme.id, programme.jour, programme.description, IDENTITY(programme.voyage) FROM App\Entity\Programme programme ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (programme.id LIKE '%".$strMainSearch."%' OR "
                ."programme.jour LIKE '%".$strMainSearch."%' OR "
                ."programme.description LIKE '%".$strMainSearch."%' OR "
                ."IDENTITY(programme.voyage) LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY programme.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'programme.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_programme", methods={"GET"})
     */
    public function show(Programme $programme): Response
    {
        //dd($programme);
        return $this->render('admin/programme/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    /**
     * @Route("/new", name="admin_programme_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $programme = new Programme();

        $form = $this->createForm(ProgrammeType::class, $programme, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($programme);
                $em->flush();
    
                $this->addFlash('success', "Le programme a été bien crée");
                
                return $this->redirectToRoute('programme_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('programme_list');
            }
        }

        return $this->render('admin/programme/new.html.twig', [
            'programme' => $programme,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_programme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Programme $programme): Response
    {
        $form = $this->createForm(ProgrammeType::class, $programme, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "Le programme a été modifié avec succès");
    
                return $this->redirectToRoute('programme_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('programme_list');
            }
        }

        return $this->render('admin/programme/edit.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_programme", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, ProgrammeRepository $programmeRepository): Response
    {
        $programme = $programmeRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($programme);
            $em->flush();
    
            $this->addFlash('success', "Le programme a été supprimé avec succès");

            return $this->redirectToRoute('programme_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('programme_list');
        }
    }
}
