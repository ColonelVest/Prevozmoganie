<?php

namespace TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TaskBundle\Entity\RepetitiveTask;

class RepetitiveTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('daysOfWeek', CollectionType::class, [
                'entry_type'   => TextType::class,
                'allow_add' => true
            ])
            ->add('beginTime', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('endTime', TimeType::class, ['widget' => 'single_text'])
            ->add('beginDate', DateType::class, [
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'format' => 'yyyy-MM-dd',
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => RepetitiveTask::class,
                'csrf_protection' => false
            ]);
    }

    public function getName()
    {
        return '';
    }
}
