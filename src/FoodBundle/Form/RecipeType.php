<?php

namespace FoodBundle\Form;

use FoodBundle\Entity\Dish;
use FoodBundle\Entity\IngredientData;
use FoodBundle\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('dish', EntityType::class, [
                'class' => Dish::class
            ])
            ->add('ingredientsData', CollectionType::class, [
                'allow_add' => true,
                'entry_type' => IngredientData::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return 'recipe';
    }
}
