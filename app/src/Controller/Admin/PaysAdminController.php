<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/pays")
 */
class PaysAdminController extends AbstractController
{
    /**
     * @Route("/", name="pays_list")
     */
    public function index(): Response
    {
        return $this->render('admin/pays/index.html.twig', []);
    }

    /**
     * @Route("/fetch-pays", name="pays_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(pays) FROM App\Entity\Pays pays';

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

        $dql = 'SELECT pays.id, pays.name FROM App\Entity\Pays pays ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");
            
            $where = "WHERE (pays.id LIKE '%".$strMainSearch."%' OR "
                ."pays.name LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY pays.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'pays.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_pays", methods={"GET"})
     */
    public function show(Pays $pays): Response
    {
        //dd($pays);
        return $this->render('admin/pays/show.html.twig', [
            'pays' => $pays,
        ]);
    }

    /**
     * @Route("/new", name="admin_pays_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $pays = new Pays();

        $form = $this->createForm(PaysType::class, $pays, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($pays);
                $em->flush();
    
                $this->addFlash('success', "Le pays a été bien crée");
                
                return $this->redirectToRoute('pays_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('pays_list');
            }
        }

        return $this->render('admin/pays/new.html.twig', [
            'pays' => $pays,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_pays_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pays $pays): Response
    {
        $form = $this->createForm(PaysType::class, $pays, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "Le pays a été modifié avec succès");
    
                return $this->redirectToRoute('pays_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('pays_list');
            }
        }

        return $this->render('admin/pays/edit.html.twig', [
            'pays' => $pays,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_pays", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, PaysRepository $paysRepository): Response
    {
        $pays = $paysRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($pays);
            $em->flush();
    
            $this->addFlash('success', "Le pays a été supprimé avec succès");

            return $this->redirectToRoute('pays_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('pays_list');
        }
    }
}
