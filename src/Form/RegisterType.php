<?php

namespace App\Form;

use App\Entity\Area;
use App\Entity\User;
use App\Repository\AreaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('area', EntityType::class, [
                'class' => Area::class,
                'choice_label' => 'name',
                'query_builder' => function (AreaRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'label' => 'Région*',
                'placeholder' => 'Sélectionnez votre région...',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['class' => 'input']
                
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email*',
                'attr' => ['class' => 'input']
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Votre pseudo*',
                'attr' => ['class' => 'input']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom*',
                'attr' => ['class' => 'input']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom*',
                'attr' => ['class' => 'input']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe*',
                'empty_data' => '',
                'attr' => ['class' => 'input']
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Votre photo',
                'constraints' => [
                        new File([
                            'maxSize' => '4096k',
                            'mimeTypes' => [
                                'image/png',
                                'image/jpeg',
                            ],
                            'mimeTypesMessage' => 'Le fichier n\'est pas au bon format (formats acceptés: .png, .jpg, .jpeg)',
                        ]),
                ],
                'attr' => ['class' => 'input']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['class' => 'form form--one-column', 'novalidate' => 'novalidate'],
        ]);
    }
}
