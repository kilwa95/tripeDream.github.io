<?php

namespace App\Form;

use App\Entity\InfoPratique;
use App\Entity\Voyage;
use App\Entity\Ville;
use App\Entity\Pays;
use App\Entity\Activite;
use App\Entity\Saison;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'help' => 'nom de voyage',
            ])

            ->add('description',TextareaType::class,[
                'help' => 'description',
            ])

            ->add('pointFort',TextareaType::class,[
                'required' => false,
            ])

            ->add('ville',EntityType::class,[
                'class' => Ville::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('pays',EntityType::class,[
                'class' => Pays::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('activity',EntityType::class,[
                'class' => Activite::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('saison',EntityType::class,[
                'class' => Saison::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            
            ->add('programme', CollectionType::class,[
                'entry_type' => ProgrammeType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'prototype' => true,
            ])

            // ->add('infoPratique', InfoPratiqueType::class)


            // ->add('tarif', CollectionType::class, [
            //     'entry_type' => TarifType::class,
            //     'entry_options' => ['label' => false],
            //     'by_reference' => false,
            //     'allow_add' => true,
            // ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
            'new' => false
        ]);
    }
}
