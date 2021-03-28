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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class WalkType extends AbstractType
{
    // This class WalkType allow to create some field in your form with Form Field Type Reference
    // thank to this method => buildform
    // Form Fiel Types Reference is for instance in our case TextType::class, EntityType::class etc
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // this line means(and the others means the same) : the field => title (arbitrary name of the field ) is known as Text
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
                // this is a validation contrainst : new NotBlank() => the field must be not empty
                // Another validation constrainst have been  coded  directly
                //on the propertie's Entity with this annotation @Assert
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
                'label' => 'Date de la randonnée ',
                'placeholder' => [
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                ],
                'years' => range(date('Y'), date('Y')+5),
            ])
            ->add('duration', ChoiceType::class, [
                'label' => 'Durée approximative',
                'placeholder' => 'Quelle est la durée de votre randonnée?',
                'choices' => [
                    '30 minutes' => '30',
                    '1 heure' => '1h',
                    '1 heure 30' => '1h30',
                    '2 heures' => '2h',
                    '2 heures 30' => '2h30',
                    '3 heures' => '3h',
                    '3 heures 30' => '3h30',
                    '4 heures' => '4h',
                    '4 heures 30' => '4h30',
                    '5 heures' => '5h',
                ],
                'multiple' => false,
                'expanded' => false,
                
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
                'attr' => [
                    'min' => 1,
                    'max' => 2000
                ]
            ])
            ->add('maxNbPersons', IntegerType::class, [
                'label' => 'Nombre de personnes maximum',
                'attr' => [
                    'min' => 1,
                ]
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
