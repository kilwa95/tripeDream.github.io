<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/voyages")
 */
class VoyageAdminController extends AbstractController
{
    /**
     * @Route("/", name="voyage_list")
     */
    public function index(): Response
    {
        return $this->render('admin/voyage/index.html.twig', []);
    }

    /**
     * @Route("/fetch-voyages", name="voyage_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(voyage) FROM App\Entity\Voyage voyage';

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

        $dql = 'SELECT voyage.id, voyage.name, voyage.description, voyage.pointFort, IDENTITY(voyage.infoPratique), IDENTITY(voyage.user) FROM App\Entity\Voyage voyage ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (voyage.id LIKE '%".$strMainSearch."%' OR "
                ."voyage.name LIKE '%".$strMainSearch."%' OR "
                ."voyage.description LIKE '%".$strMainSearch."%' OR "
                ."voyage.pointFort LIKE '%".$strMainSearch."%' OR "
                ."IDENTITY(voyage.infoPratique) LIKE '%".$strMainSearch."%' OR "
                ."IDENTITY(voyage.user) LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY voyage.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'voyage.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_voyage", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        //dd($voyage);
        return $this->render('admin/voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    /**
     * @Route("/new", name="admin_voyage_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $voyage = new Voyage();

        $form = $this->createForm(VoyageType::class, $voyage, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($voyage);
                $em->flush();
    
                $this->addFlash('success', "Le voyage a été bien crée");
                
                return $this->redirectToRoute('voyage_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('voyage_list');
            }
        }

        return $this->render('admin/voyage/new.html.twig', [
            'voyage' => $voyage,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_voyage", methods={"GET","POST"})
     */
    public function edit(Request $request, Voyage $voyage): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "Le voyage a été modifié avec succès");
    
                return $this->redirectToRoute('voyage_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('voyage_list');
            }
        }

        return $this->render('admin/voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_voyage", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, VoyageRepository $infoPrRepository): Response
    {
        $voyage = $infoPrRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($voyage);
            $em->flush();
    
            $this->addFlash('success', "Le voyage a été supprimé avec succès");

            return $this->redirectToRoute('voyage_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('voyage_list');
        }
    }
}
