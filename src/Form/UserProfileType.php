<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname')
            ->add('email')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,  // Make it optional for profile updates
                'first_options' => [
                    'label' => 'New Password',
                    'attr' => [
                        'class' => 'w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-blue-500',
                    ],
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'class' => 'w-full px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:border-blue-500',
                    ],
                ],
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
