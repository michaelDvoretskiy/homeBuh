<?php

namespace HomeBuhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddExpenseSum extends AbstractType
{
    private $categories;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "date",
                DateType::class,
                [
                    'label' => 'Date:',
                    'widget' => 'single_text',
                ]
            )
            ->add(
                "category",
                ChoiceType::class,
                [
                    'label' => 'Category:',
                    'choices' => $options['categories'],
                ]
            )
            ->add(
                "add",
                SubmitType::class
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'categories' => [],
            ]
        );
    }

    public function getName()
    {
        return 'add_expense_sum';
    }
}
