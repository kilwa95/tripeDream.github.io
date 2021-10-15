<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Tarif;
use App\Form\TarifType;
use App\Repository\TarifRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/tarif")
 */
class TarifAdminController extends AbstractController
{
    /**
     * @Route("/", name="tarif_list")
     */
    public function index(): Response
    {
        return $this->render('admin/tarif/index.html.twig');
    }

    /**
     * @Route("/fetch-tarifs", name="tarif_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(tarif) FROM App\Entity\Tarif tarif';

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

        $dql = 'SELECT tarif.id, tarif.prix, tarif.depart, tarif.retour, tarif.capacite, IDENTITY(tarif.voyage) FROM App\Entity\Tarif tarif ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");
            $where = "WHERE (tarif.id LIKE '%".$strMainSearch."%' OR "
                ."tarif.prix LIKE '%".$strMainSearch."%' OR "
                ."tarif.depart LIKE '%".$strMainSearch."%' OR "
                ."tarif.retour LIKE '%".$strMainSearch."%' OR "
                ."tarif.capacite LIKE '%".$strMainSearch."%' OR "
                ."IDENTITY(tarif.voyage) LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY tarif.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'tarif.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_tarif", methods={"GET"})
     */
    public function show(Tarif $tarif): Response
    {
        //dd($tarif);
        return $this->render('admin/tarif/show.html.twig', [
            'tarif' => $tarif,
        ]);
    }

    /**
     * @Route("/new", name="admin_tarif_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $tarif = new Tarif();

        $form = $this->createForm(TarifType::class, $tarif, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($tarif);
                $em->flush();
    
                $this->addFlash('success', "Le tarif a été bien crée");
                
                return $this->redirectToRoute('tarif_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('tarif_list');
            }
        }

        return $this->render('admin/tarif/new.html.twig', [
            'tarif' => $tarif,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tarif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tarif $tarif): Response
    {
        $form = $this->createForm(TarifType::class, $tarif, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "Le tarif a été modifié avec succès");
    
                return $this->redirectToRoute('tarif_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('tarif_list');
            }
        }

        return $this->render('admin/tarif/edit.html.twig', [
            'tarif' => $tarif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_tarif", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, TarifRepository $tarifRepository): Response
    {
        $tarif = $tarifRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($tarif);
            $em->flush();
    
            $this->addFlash('success', "Le tarif a été supprimé avec succès");

            return $this->redirectToRoute('tarif_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('tarif_list');
        }
    }
}
