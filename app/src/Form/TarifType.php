<?php

namespace App\Form;

use App\Entity\Tarif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix', MoneyType::class)
            
            ->add('depart', DateType::class, [
                'label'  => "Date de départ",
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('retour', DateType::class,[
                'label'  => "Date de retour",
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('capacite', IntegerType::class, [
                'label'  => "Capacité",
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
            ])
        ;
        
        if ($options['action'] != 'new' && $options['action'] != 'edit') {
            $builder->remove('submit');
            $builder->remove('reset');
        }
        
        if ($options['action'] == 'edit') {
            $builder->remove('reset');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}