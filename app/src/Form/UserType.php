<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                    'label' => "Nom d'utilisateur",
                    'label_attr' => ['class' => 'label'],
                    'attr' => [
                        'class' => 'input mb-4',
                        'placeholder' => "Nom d'utilisateur"
                        ]
                    ]
                    )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe', 'attr' => ['class' => 'input mb-4', 'placeholder' => "Mot de passe"]],
                'second_options' => ['label' => 'Répéter le mot de passe', 'attr' => ['class' => 'input mb-4', 'placeholder' => "Répéter le mot de passe"]],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%+])(?!.*(.)\1{2}).*[a-z]/m',
                        'message' => 'Votre mot de passe doit comporter au moins 8 caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.'
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => 'input mb-4',
                    'placeholder' => "E-mail"
                ],
                'label_attr' => ['class' => 'label']
            ])
            ->add('lastname', TextType::class, [
                'label'  => "Nom de famille",
                'label_attr' => ['class' => 'label'],
                'attr'   => [
                    'class'   => 'input mb-4',
                    'placeholder' => "Nom de famille"
                    ]
                ]
            )
            ->add('roles', ChoiceType::class, [
                'label'  => "Rôle",
                'attr' => [
                    'class' => 'mb-4',
                ],
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices'  => [
                    'Voyageur' => 'ROLE_USER',
                    'Agencier' => 'ROLE_AGENCE',
                    //'Administrateur' => 'ROLE_ADMIN',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label'  => "Envoyer",
                'attr' => [
                    'class' => 'btn btn-block btn-success'
                ]
            ])
            ->add('reset', ResetType::class, [
                'label'  => "Réinitialiser",
                'attr' => [
                    'class' => 'btn btn-block btn-danger',
                    'type' => 'reset'
                ]
            ]);
        
        if ($options['action'] == 'edit' || $options['type'] == 'edit_profil_front') {
            $builder->remove('reset');
        }

        if ($this->security->getUser() === null || ($this->security->getUser()->getRoles()[0] !== 'ROLE_ADMIN') || $options['type'] == 'edit_profil_front') {
            $builder->remove('submit');
            $builder->remove('reset');
        }
        
        if ($this->security->getUser()){
            $currentUserId = $this->security->getUser()->getId();
        } else {
            $currentUserId = null;
        }

        if ($options['data']->getId() == $currentUserId && $this->security->getUser() !== null) {
            $builder->remove('roles');
        } else {
            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        // transform the array to a string
                        return count($rolesArray)? $rolesArray[0]: null;
                    },
                    function ($rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
                ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'type' => null,
        ));
    }
}
