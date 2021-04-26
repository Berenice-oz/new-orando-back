<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BackWalkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [        
                'label' => 'Statut de la randonnée',
                'choices' => [
                    'Annulée' => 0,
                    'A venir' => 1,
                    'Terminée' => 2,
                ],
                'constraints'=> [
                    New NotBlank(),
                ]
            ])
        
        ;  
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'form-edit'],
        ]);
    }
}
