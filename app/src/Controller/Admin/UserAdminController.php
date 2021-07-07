<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;

/**
 * @Route("/admin/users")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("/", name="users_list")
     */
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig');
    }

    /**
     * @Route("/fetch-users", name="users_fetching", methods={"GET", "POST"})
     */
    public function getUsersJson(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $records_per_page = 10;
        $start_from = 0;
        $current_page_number = 0;

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

        $dql = 'SELECT user.id, user.username, user.email, user.roles, user.lastName FROM App\Entity\User user ';

        if (!empty($request->get("searchPhrase")))
        {
            $strMainSearch = $request->get("searchPhrase");
            $dql .= "WHERE (user.id LIKE '%".$strMainSearch."%' OR "
                ."user.username LIKE '%".$strMainSearch."%' OR "
                ."user.email LIKE '%".$strMainSearch."%' OR "
                ."user.roles LIKE '%".$strMainSearch."%' OR "
                ."user.lastName LIKE '%".$strMainSearch."%') ";
        }
        $order_by = '';

        if ($request->get("sort") != null && is_array($request->get("sort")))
        {
            foreach($request->get("sort") as $key => $value)
            {
                $order_by .= " $key $value, ";
            }
        }
        else
        {
            $dql .= 'ORDER BY user.id ASC ';
        }
        
        if ($order_by != '')
        {
            $orderBy = 'user.'. substr($order_by, 0, -2);
            $dql .= ' ORDER BY ' . $orderBy;
        }

        $items = $em
            ->createQuery($dql)
            ->setFirstResult($start_from)
            ->setMaxResults($records_per_page)
            ->getResult();

        $data = [];
        foreach ($items as $item) {
            $role = reset($item['roles']);
            switch ($role) {
                case 'ROLE_USER':
                    $role = "Voyageur";
                    break;
                case 'ROLE_AGENCE':
                    $role = "Agencier";
                    break;
                case 'ROLE_ADMIN':
                    $role = "Administrateur";
                    break;
            }
            $item['roles'] = $role;

            $data[] = $item;
        }

        $recordsTotal = $em
            ->createQuery('SELECT count(user) FROM App\Entity\User user')
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
     * @Route("/{id}", requirements={ "id" : "\d+|rowId" }, name="show_user", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="new_user", methods={"GET", "POST"})
     */
    public function newUser(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['action' => 'new']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
    
                $this->addFlash('success', "L'utilisateur a été bien crée");
                
                return $this->redirectToRoute('users_list');
            } catch(\Exception $e){
                $this->addFlash('danger', $e->getMessage());
                
                return $this->redirectToRoute('users_list');
            }
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'operation' => 'new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit_user", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user, ['action' => 'edit']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', "L'utilisateur a été modifié avec succès");
    
                return $this->redirectToRoute('users_list');
            } catch(\Exception $e){
                $this->addFlash('danger', $e->getMessage());
                
                return $this->redirectToRoute('users_list');
            }
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_user", methods={"DELETE", "GET", "POST"})
     */
    public function deleteUser(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
    
            $this->addFlash('success', "L'utilisateur a été supprimé avec succès");

            return $this->redirectToRoute('users_list');
        } catch(\Exception $e){
            $this->addFlash('danger', $e->getMessage());
            
            return $this->redirectToRoute('users_list');
        }
    }
}
