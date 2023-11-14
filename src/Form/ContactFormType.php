<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType; 

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'example@example.com'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'mode' => 'strict'
                    ])
                ]
            ])
            ->add('full_name', TextType::class, [
                'label' => 'Name',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'John Doe'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Type a message here...',
                    'rows' => 5
                ],
                'constraints' => [
                    new NotBlank(),
                   
                ]
            ]);

    }
}