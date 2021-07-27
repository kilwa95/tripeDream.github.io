<?php

namespace App\Form;

use App\Entity\Saison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

class SaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
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
            'data_class' => Saison::class,
        ]);
    }
}
