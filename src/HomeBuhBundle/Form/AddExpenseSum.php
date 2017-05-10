<?php

namespace HomeBuhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                "sum",
                NumberType::class,
                [
                    'label' => 'Sum: ',
                    'attr' => [
                        ''
                    ],
                ]
            )
            ->add(
                "comment",
                TextType::class,
                [
                    'label' => 'Comment: ',
                ]
            )
            ->add(
                "type",
                ChoiceType::class,
                [
                    'label' => 'Type:',
                    'choices' => $options['acctypes'],
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
                'acctypes' => [],
            ]
        );
    }

    public function getName()
    {
        return 'add_expense_sum';
    }
}
