<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                    'require' => true,
                    'placeholder' => 'Enter a name'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'require' => true,
                    'placeholder' => 'Enter your email address'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Your message',
                'attr' => [
                    'rows' => 8,
                    'require' => true,
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('captcha', CaptchaType::class, [
                'attr' => [
                    'style' => 'width: 200px'
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
