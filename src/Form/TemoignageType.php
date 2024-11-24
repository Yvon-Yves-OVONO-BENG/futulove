<?php

namespace App\Form;

use App\Entity\Temoignage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Contracts\Translation\TranslatorInterface;

class TemoignageType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreTemoignage', TextType::class, [
                'label' => $this->translator->trans('Titre du témoignage'),
                'required' => true,
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => $this->translator->trans("Titre de votre témoignage"),
                ]
            ])
            ->add('temoignage', TextareaType::class, [
                'label' => $this->translator->trans('Votre témoignage'),
                'required' => true,
                'attr' => [
                    'placeholder' => $this->translator->trans("Votre témoignage"),
                ]
            ])
            ->add('photoTemoignages', CollectionType::class, [
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
            'data_class' => Temoignage::class,
        ]);
    }
}
