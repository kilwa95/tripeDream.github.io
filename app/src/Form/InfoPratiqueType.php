<?php


namespace App\Form;


use App\Entity\InfoPratique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoPratiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rendez_vous')
            ->add('fin_sejour')
            ->add('hebergement')
            ->add('repas')
            ->add('covid19')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoPratique::class,
        ]);
    }
}