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

use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                    'label'  => "Nom d'utilisatuer",
                    'attr'   => [
                        'class'   => 'c4'
                        ]
                    ]
                )
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('email',EmailType::class, [
                'label' => 'Adresse e-mail'
            ])
            ->add('lastname', TextType::class, [
                'label'  => "Nom de famille",
                'attr'   => [
                    'class'   => 'c4'
                    ]
                ]
            )
            ->add('roles', ChoiceType::class, [
                'label'  => "Rôle",
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices'  => [
                    'Voyageur' => 'ROLE_USER',
                    'Agencier' => 'ROLE_AGENCE',
                    'Administrateur' => 'ROLE_ADMIN',
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
        
        if ($options['action'] == 'edit') {
            $builder->remove('reset');
        }

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


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
