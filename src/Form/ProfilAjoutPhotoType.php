<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProfilAjoutPhotoType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photos', CollectionType::class, [
            'label' => false,
            'required' => false,
            'entry_type' => FileType::class,
            'entry_options' => [
                'label' => false,
                'attr' =>[
                    'accept' => 'image/*',
                    'class' => 'form-control form-control-sm'
                ]
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'mapped' => false
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
