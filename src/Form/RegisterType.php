<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email:'
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Votre pseudo:',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom:',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom:',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'empty_data' => '',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
