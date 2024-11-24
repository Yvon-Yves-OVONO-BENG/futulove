<?php

namespace App\Form;

use App\Entity\User;
use App\Form\PhotType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photos', CollectionType::class, [
            'label' => false,
            'entry_type' => PhotType::class,
            'entry_options' => [
                'label' => false
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
