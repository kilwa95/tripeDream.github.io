<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\InfoPratique;
use App\Form\InfoPratiqueType;
use App\Repository\InfoPratiqueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/info_pratiques")
 */
class InfoPrAdminController extends AbstractController
{
    /**
     * @Route("/", name="info_pr_list")
     */
    public function index(): Response
    {
        return $this->render('admin/info_pr/index.html.twig', [
            'controller_name' => 'InfoPrAdminController',
        ]);
    }

    /**
     * @Route("/fetch-info-pr", name="info_pr_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(info_pr) FROM App\Entity\InfoPratique info_pr';

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

        $dql = 'SELECT info_pr.id, info_pr.depart, info_pr.retour, info_pr.duree, info_pr.hebergement, info_pr.repas, info_pr.covid19 FROM App\Entity\InfoPratique info_pr ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");

            $where = "WHERE (info_pr.id LIKE '%".$strMainSearch."%' OR "
                ."info_pr.depart LIKE '%".$strMainSearch."%' OR "
                ."info_pr.retour LIKE '%".$strMainSearch."%' OR "
                ."info_pr.duree LIKE '%".$strMainSearch."%' OR "
                ."info_pr.hebergement LIKE '%".$strMainSearch."%' OR "
                ."info_pr.repas LIKE '%".$strMainSearch."%' OR "
                ."info_pr.covid19 LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY info_pr.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'info_pr.'. substr($order_by, 0, -2);
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_info_pr", methods={"GET"})
     */
    public function show(InfoPratique $info_pr): Response
    {
        //dd($info_pr);
        return $this->render('admin/info_pr/show.html.twig', [
            'info_pr' => $info_pr,
        ]);
    }

    /**
     * @Route("/new", name="info_pr_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $info_pr = new InfoPratique();

        $form = $this->createForm(InfoPratiqueType::class, $info_pr, ['action' => 'new', 'user' => 'admin']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($info_pr);
                $em->flush();
    
                $this->addFlash('success', "L'information pratique a été bien crée");
                
                return $this->redirectToRoute('info_pr_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('info_pr_list');
            }
        }

        return $this->render('admin/info_pr/new.html.twig', [
            'info_pr' => $info_pr,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_info_pr", methods={"GET","POST"})
     */
    public function edit(Request $request, InfoPratique $info_pr): Response
    {
        $form = $this->createForm(InfoPratiqueType::class, $info_pr, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "L'information pratique a été modifié avec succès");
    
                return $this->redirectToRoute('info_pr_list');
            } catch(\Exception $e) {
                $this->addFlash('danger', "Une erreur est survenue");
                
                return $this->redirectToRoute('info_pr_list');
            }
        }

        return $this->render('admin/info_pr/edit.html.twig', [
            'info_pr' => $info_pr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_info_pr", methods={"DELETE", "GET", "POST"})
     */
    public function delete(int $id, InfoPratiqueRepository $infoPrRepository): Response
    {
        $info_pr = $infoPrRepository->find($id);
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($info_pr);
            $em->flush();
    
            $this->addFlash('success', "L'information pratique a été supprimé avec succès");

            return $this->redirectToRoute('info_pr_list');
        } catch(\Exception $e) {
            $this->addFlash('danger', "Une erreur est survenue");
            
            return $this->redirectToRoute('info_pr_list');
        }
    }
}
