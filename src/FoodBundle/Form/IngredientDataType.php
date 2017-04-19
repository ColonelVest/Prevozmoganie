<?php

namespace FoodBundle\Form;

use FoodBundle\Entity\Ingredient;
use FoodBundle\Entity\IngredientData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class
            ])
            ->add('count', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => IngredientData::class,
                'csrf_protection' => false
            ]);
    }

    public function getBlockPrefix()
    {
        return 'ingredient_data';
    }
}
