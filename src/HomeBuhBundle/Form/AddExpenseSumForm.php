<?php

namespace HomeBuhBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddExpenseSumForm extends AbstractType
{
    private $categories;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "date",
                DateType::class,
                [
                    'label' => 'Date:',
                    'widget' => 'single_text',
                    'property_path' => 'data',
                ]
            )
            ->add(
                "category",
                EntityType::class,
                [
                    'label' => 'Category:',
                    'class' => "HomeBuhBundle\Entity\Category",
                    'choices' => $options['categories'],
                    'property_path' => 'cat',
                ]
            )
            ->add(
                "summa",
                IntegerType::class,
                [
                    'label' => 'Sum: ',
                    'attr' => [
                        'placeholder' => '0',
                        'property_path' => 'summa',
                    ],
                ]
            )
            ->add(
                "comment",
                TextType::class,
                [
                    'label' => 'Comment: ',
                    'property_path' => 'text',
                    'required' => false,
                ]
            )
            ->add(
                "type",
                EntityType::class,
                [
                    'label' => 'Type:',
                    'class' => "HomeBuhBundle\Entity\Account",
                    'choices' => $options['acctypes'],
                    'property_path' => 'account',
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
                "data_class" => "HomeBuhBundle\Entity\Expense",
                'categories' => [],
                'acctypes' => [],
            ]
        );
    }

//    public function getName()
//    {
//        return 'add_expense_sum';
//    }

    public function getBlockPrefix()
    {
        return 'add_expense_sum';
    }


}
