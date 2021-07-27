<?php

namespace App\Form;

use App\Entity\Programme;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour',IntegerType::class)
            ->add('description',TextareaType::class)
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
            'data_class' => Programme::class,
        ]);
    }
}