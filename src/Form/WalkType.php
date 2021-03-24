<?php

namespace App\Form;

use App\Entity\Area;
use App\Repository\AreaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
 use Symfony\Component\Form\Extension\Core\Type\NumberType;
class WalkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('area', EntityType::class, [
                'class' => Area::class,
                'choice_label' => 'name',
                'query_builder' => function (AreaRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'label' => 'Région',
                'placeholder' => 'Sélectionner votre région...',
                'constraints' => [
                    new NotBlank(),
                ],
               
            ])
            ->add('startingPoint', TextType::class, [
                'label' => 'Point de départ',
            ])
            ->add('endPoint', TextType::class, [
                'label' => 'Point d\'arrivée',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de la randonnée',
                'empty_data' => '',
                
            ])
            ->add('duration', ChoiceType::class, [
                'label' => 'Durée approximative',
                'placeholder' => 'Sélectionner',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,

                ],
                
            ])
            ->add('difficulty', ChoiceType::class, [
                'label' => 'Niveau de difficulté',
                'choices' => [
                    'Facile' => 'facile',
                    'Moyen' => 'moyen',
                    'Difficile' => 'difficile'

                ],
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('elevation', IntegerType::class, [
                'label' => 'Dénivelé',
            ])
            ->add('maxNbPersons', IntegerType::class, [
                'label' => 'Nombre de personnes maximum',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])

           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
