<?php

namespace TaskBundle\Form;

use TaskBundle\Entity\Period;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime', TimeType::class, [
                'label' => 'label.schedule.startTime',
                'allow_add' => true,
                'prototype' => true,
                 'attr' => [
                     'autofocus' => true,
                 ],
                'data' => new \DateTime('7:00')
            ])
            ->add('periods', CollectionType::class, [
                'entry_type' => PeriodType::class,
                'label' => 'label.schedule.period',
                'entry_options' => [

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'allow_extra_fields' => true,
                'data_class' => 'TaskBundle\Entity\Schedule',
                'attr' => [
                    'class' => 'form-horizontal'
                ]
            )
        );
    }
}