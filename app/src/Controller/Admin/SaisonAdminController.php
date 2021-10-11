<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Saison;
use App\Form\SaisonType;
use App\Repository\SaisonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/saison")
 */
class SaisonAdminController extends AbstractController
{
    /**
     * @Route("/", name="saison_list")
     */
    public function index(): Response
    {
        return $this->render('admin/saison/index.html.twig', []);
    }

    /**
     * @Route("/fetch-saisons", name="saison_fetching", methods={"GET", "POST"})
     */
    public function getJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

        $dqlCount = 'SELECT count(saison) FROM App\Entity\Saison saison';

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

        $dql = 'SELECT saison.id, saison.name FROM App\Entity\Saison saison ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");
            
            $where = "WHERE (saison.id LIKE '%".$strMainSearch."%' OR "
                ."saison.name LIKE '%".$strMainSearch."%') ";

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
            $dql .= 'ORDER BY saison.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'saison.'. substr($order_by, 0, -2);
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

        $recordsTotal = $em
            ->createQuery('SELECT count(saison) FROM App\Entity\Saison saison')
            ->getSingleScalarResult();
        
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_saison", methods={"GET"})
     */
    public function show(Saison $saison): Response
    {
        //dd($saison);
        return $this->render('admin/saison/show.html.twig', [
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/new", name="admin_saison_new", methods={"GET", "POST"})
     */
    // public function new(Request $request): Response
    // {
    //     $saison = new Saison();

    //     $form = $this->createForm(SaisonType::class, $saison, ['action' => 'new']);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try{
    //             $em = $this->getDoctrine()->getManager();
    //             $em->persist($saison);
    //             $em->flush();
    
    //             $this->addFlash('success', "La saison a été bien crée");
                
    //             return $this->redirectToRoute('saison_list');
    //         } catch(\Exception $e) {
    //             $this->addFlash('danger', "Une erreur est survenue");
                
    //             return $this->redirectToRoute('saison_list');
    //         }
    //     }

    //     return $this->render('admin/saison/new.html.twig', [
    //         'saison' => $saison,
    //         'operation' => 'new',
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}/edit", name="admin_saison_edit", methods={"GET","POST"})
     */
    // public function edit(Request $request, Saison $saison): Response
    // {
    //     $form = $this->createForm(SaisonType::class, $saison, ['action' => 'edit']);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try{
    //             $this->getDoctrine()->getManager()->flush();
    //             $this->addFlash('success', "La saison a été modifié avec succès");
    
    //             return $this->redirectToRoute('saison_list');
    //         } catch(\Exception $e) {
    //             $this->addFlash('danger', "Une erreur est survenue");
                
    //             return $this->redirectToRoute('saison_list');
    //         }
    //     }

    //     return $this->render('admin/saison/edit.html.twig', [
    //         'saison' => $saison,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/delete/{id}", name="delete_saison", methods={"DELETE", "GET", "POST"})
     */
    // public function delete(int $id, SaisonRepository $saisonRepository): Response
    // {
    //     $saison = $saisonRepository->find($id);
        
    //     try{
    //         $em = $this->getDoctrine()->getManager();
    //         $em->remove($saison);
    //         $em->flush();
    
    //         $this->addFlash('success', "La saison a été supprimé avec succès");

    //         return $this->redirectToRoute('saison_list');
    //     } catch(\Exception $e) {
    //         $this->addFlash('danger', "Une erreur est survenue");
            
    //         return $this->redirectToRoute('saison_list');
    //     }
    // }
}
