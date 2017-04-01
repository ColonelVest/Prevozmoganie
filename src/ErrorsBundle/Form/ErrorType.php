<?php

namespace ErrorsBundle\Form;

use ErrorsBundle\Entity\Error;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ErrorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextType::class)
            ->add('solution', TextType::class)
            ->add('reason', TextType::class)
            ->add('id', NumberType::class, [
                'mapped' => false
            ])
            ->add('type', TextType::class)
            ->add('isFixed', CheckboxType::class)
            ->add('prevention', TextType::class)
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Error::class,
                'csrf_protection' => false
            ]);
    }

    public function getBlockPrefix()
    {
        return 'error';
    }
}
