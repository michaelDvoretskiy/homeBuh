<?php

namespace HomeBuhBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportExpensesForm extends AbstractType
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
            )
            ->add(
                "endDate",
                DateType::class,
                [
                    'label' => 'To : ',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                "paymentType",
                ChoiceType::class,
                [
                    'label' => 'Type : ',
                    'choices' => $options['acctypes'],
                    'property_path' => 'account',
                ]
            )
            ->add(
                "report",
                ButtonType::class,
                [
                    'label' => 'report',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'acctypes' => [],
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'report_expenses_form';
    }
}
