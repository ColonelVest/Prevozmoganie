<?php

namespace FoodBundle\Form;

use FoodBundle\Entity\Dish;
use FoodBundle\Entity\MealType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepetitiveMealForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('beginDate', DateType::class, [
                    'format' => 'yyyy-MM-dd',
                    'widget' => 'single_text',
                ]
            )
            ->add('endDate', DateType::class, [
                    'format' => 'yyyy-MM-dd',
                    'widget' => 'single_text',
                ]
            )
            ->add('daysOfWeek', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => TextType::class
            ])
            ->add('weekFrequency', NumberType::class)
            ->add('newMealsCreateTask', CheckboxType::class)
            ->add('dishes', EntityType::class, [
                    'class' => Dish::class,
                    'multiple' => true,
                ]
            )
            ->add('mealType', EntityType::class, [
                'class' => MealType::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'FoodBundle\Model\RepetitiveMeal',
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'meal';
    }
}
