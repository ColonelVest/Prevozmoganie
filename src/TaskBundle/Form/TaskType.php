<?php

namespace TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('id', IntegerType::class, ['mapped' => false])
            ->add('beginTime', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('endTime', TimeType::class, ['widget' => 'single_text'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'TaskBundle\Entity\Task',
                'csrf_protection' => false
            )
        );
    }

    public function getBlockPrefix()
    {
        return 'task';
    }
}
