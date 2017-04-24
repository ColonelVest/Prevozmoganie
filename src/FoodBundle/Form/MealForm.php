<?php

namespace FoodBundle\Form;

use FoodBundle\Entity\Dish;
use FoodBundle\Entity\Meal;
use FoodBundle\Entity\MealType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('mealType', EntityType::class, [
                'class' => MealType::class
            ])
            ->add('dishes', EntityType::class, [
                'multiple' => true,
                'class' => Dish::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Meal::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'meal';
    }
}
