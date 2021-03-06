<?php


namespace App\Form;


use App\Entity\Tarif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class TarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix',MoneyType::class)
            
            ->add('depart',DateType::class,[
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('arrive',DateType::class,[
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
                'format' => 'yyyy-MM-dd',
            ])

            ->add('capacite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}