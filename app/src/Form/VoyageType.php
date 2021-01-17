<?php

namespace App\Form;

use App\Entity\InfoPratique;
use App\Entity\Voyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('pointFort')
            ->add('ville')
            ->add('pays')
            ->add('activity')
            ->add('saison')
            ->add('programme', CollectionType::class, [
                'entry_type' => ProgrammeType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
            ])
            ->add('infoPratique', InfoPratiqueType::class)
            ->add('tarif', CollectionType::class, [
                'entry_type' => TarifType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
            ])
            ->add('save', SubmitType::class, [
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
        ]);
    }
}
