<?php

namespace NotesBundle\Form;

use NotesBundle\Entity\Listener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListenerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', TextType::class)
            ->add('actions', CollectionType::class, [
                'allow_add' => true
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Listener::class,
                'csrf_protection' => false
            ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
