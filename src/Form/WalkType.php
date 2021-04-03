<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Area;
use App\Repository\TagRepository;
use App\Repository\AreaRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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

            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'query_builder' => function (TagRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'label' => 'Tag',
                'placeholder' => 'Sélectionner votre Tag...',
                'constraints' => [
                    new NotBlank(),
                ],
                // multiple => true is important because tags is a collection(cf Entity Walk => tags)
                'multiple' => true,
                'expanded' => true,
            ])
            
            ->add('startingPoint', TextType::class, [
                'label' => 'Point de départ',
            ])
            ->add('endPoint', TextType::class, [
                'label' => 'Point d\'arrivée',
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date de la randonnée avec heure de départ ',
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
            ->add('difficulty', null, [
                'label' => 'Niveau de difficulté',
                // 'choices' => [
                //     'Facile' => 'facile',
                //     'Moyen' => 'moyen',
                //     'Difficile' => 'difficile'

                // ],
                // 'multiple' => false,
                // 'expanded' => true,
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

            // we add an event because when we create a walk , we don't need status field
            // except when it is to edit the walk 
            // PRE_SET_DATA allow to interact with the form and the Entity
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $walk = $event->getData();
               
                $form = $event->getForm();
                
                if ($walk->getId() !== null) {
                    $form->add('status', ChoiceType::class, [
                        
                        'label' => 'Statut de votre randonnée',
                        'choices' => [
                            'Annulée' => 0,
                            'A venir' => 1,
                            'Terminée' => 2,
                        ]
                    ]);
                } 
            })
        ;
    
    }   

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
