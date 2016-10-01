<?php

namespace ScheduleBundle\Form;

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
                'hours' => 7,
                 'attr' => [
                     'autofocus' => true,

                 ],
            ])
//            ->add('periods', CollectionType::class, [
//
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'allow_extra_fields' => true,
                'data_class' => 'ScheduleBundle\Entity\Schedule'
            )
        );
    }
}