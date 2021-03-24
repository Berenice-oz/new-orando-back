<?php

namespace App\Form;

use App\Entity\Area;
use App\Repository\AreaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                'label' => 'Région'
               
            ])
            ->add('startingPoint', TextType::class, [
                'label' => 'Point de départ',
            ])
            ->add('endPoint', TextType::class, [
                'label' => 'Point d\'arrivée (si différent)',
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
