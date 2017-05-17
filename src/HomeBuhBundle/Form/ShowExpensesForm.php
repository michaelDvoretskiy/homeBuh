<?php

namespace HomeBuhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowExpensesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "beginDate",
                DateType::class,
                [
                    'label' => 'From : ',
                    'widget' => 'single_text',
                ]
            )->add(
                "endDate",
                DateType::class,
                [
                    'label' => 'To : ',
                    'widget' => 'single_text',
                ]
            )->add(
                "view",
                ButtonType::class,
                [
                    'label' => 'view',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }

//    public function getName()
//    {
//        return 'show_expenses_form';
//    }
    public function getBlockPrefix()
    {
        return 'show_expenses_form';
    }
}
