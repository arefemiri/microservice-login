<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'trim' => true,
            ])
            ->add('family', TextType::class, [
                'trim' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('username', TextType::class, [
                'trim' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('email', EmailType::class, [
                'trim' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('countryCode', TextType::class, [
                'trim' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('mobileNo', TextType::class, [
                'trim' => true,
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('password', PasswordType::class, [
                'trim' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'max' => 20,
                    ]),]
            ])
            ->add('passportNumber', TextType::class, [
                'trim' => true,
            ])
            ->add('passportImage', FileType::class, [
                'trim' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
