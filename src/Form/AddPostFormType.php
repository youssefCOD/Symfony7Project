<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Posts;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddPostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class , [
                'label' => 'Name of the post' ,
                'constraints' => [
                    new NotBlank()
                ]    
            ])
            ->add('content' , TextType::class , [
                'label' => 'Content of the Post'
            ])
            ->add('featuredImage' ,FileType::class,[
                'label' => 'Image of the post' ,
                'attr' => [
                    'accept' => 'image/png , image/jpeg , image/webp'
                ],
                'constraints' => [
                    new Image(
                        allowPortrait:false,
                        mimeTypes:[
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ]
                    )
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' =>true
                
            ])
            ->add('keywords', EntityType::class, [
                'class' => Keywords::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' =>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
