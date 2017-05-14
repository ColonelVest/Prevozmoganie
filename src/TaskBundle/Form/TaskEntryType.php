<?php

namespace TaskBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TaskBundle\Entity\Task;
use TaskBundle\Entity\TaskEntry;
use UserBundle\Entity\User;

class TaskEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'format' => 'ddMMyyyy',
                'widget' => 'single_text',
            ])
            ->add('deadline', DateType::class, [
                'format' => 'ddMMyyyy',
                'widget' => 'single_text',
            ])
            ->add('isCompleted', CheckboxType::class)
            ->add('task', EntityType::class, [
                'class' => Task::class,
                'required' => true
            ])
            ->add('user', EntityType::class, [
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => TaskEntry::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'task_entry';
    }
}
