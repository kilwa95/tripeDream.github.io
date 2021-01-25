<?php 
namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
           
            // 3) Encode the password (you could also do this via   
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
                
            // envoie d'un mail lorsque l'utilisateur s'enregistre
            

            // flash message lorsque l'utilisateur est ajouté
                $this->addFlash('success', 'Utilisateur ajouté avec succès');
                return $this->redirectToRoute('navigation');
        }
        return $this->render(
            'security/register.html.twig',['form' => $form->createView()]);
    }
}