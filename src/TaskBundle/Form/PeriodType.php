<?php

namespace TaskBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class)
            ->add('begin', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('end', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('date', DateType::class, [
                'format' => 'ddMMyyyy',
                'widget' => 'single_text'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'TaskBundle\Entity\Period',
                'csrf_protection' => false
            )
        );
    }


    public function getName()
    {
        return '';
    }
}
