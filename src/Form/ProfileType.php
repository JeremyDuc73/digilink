<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('phoneNumber')
            ->add('grade', EntityType::class, [
                'class'=>Grade::class,
                'choice_label'=>'gradeName'
            ])
            ->add('link', CollectionType::class, [
                'entry_type'=>LinkType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'required'=>true,
                'by_reference'=>false,
                'disabled'=>false,
                'prototype'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
