<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter a name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Enter your email address'
                ]
            ])
            ->add('message', CKEditorType::class, [
                'label' => 'Your message',
                'attr' => [
                    'rows' => 8,
                    'class' => 'form-control mb-3'
                ]
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
