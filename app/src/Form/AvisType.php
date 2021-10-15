<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'mb-4',
                    // 'placeholder' => "Titre"
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'mb-4',
                    // 'placeholder' => "Description"
                ]
            ])
            ->add('compteur', IntegerType::class, [
                'attr' => [
                    'class' => 'mb-4',
                    'min' => 1,
                    'max' => 5
                ],
                'label'=> "Avis",
                'help' => "Veuillez indiquer entre 1 et 5 étoiles"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
