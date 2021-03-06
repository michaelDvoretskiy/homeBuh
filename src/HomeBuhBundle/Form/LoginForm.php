<?php

namespace HomeBuhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',
                TextType::class,
                [
                    'property_path' => 'username',
                    'label' => 'Username',
                ])
            ->add('password',
                PasswordType::class,
                [
                    'property_path' => 'password',
                    'label' => 'Password',
                ])
            ->add('login',
                SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }

    public function getBlockPrefix()
    {
        return 'login';
    }
}
