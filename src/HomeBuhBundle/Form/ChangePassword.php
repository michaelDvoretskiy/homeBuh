<?php

namespace HomeBuhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "oldPass",
                PasswordType::class,
                [
                    'label' => 'old : ',
                    'constraints' => array(
                        new \Symfony\Component\Security\Core\Validator\Constraints\UserPassword(),
                    ),
                    'mapped' => false,
                    'required' => true,
                ]
            )->add(
                "newPass",
                PasswordType::class,
                [
                    'label' => 'new : ',
                ]
            )->add(
                "newPass2",
                PasswordType::class,
                [
                    'label' => 'repeat : ',
                ]
            )->add(
                "change",
                SubmitType::class,
                [
                    'label' => 'Change',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'change_password';
    }
}

