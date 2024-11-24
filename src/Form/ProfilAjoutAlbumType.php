<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\TypeAlbum;
use App\Repository\TypeAlbumRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProfilAjoutAlbumType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titreAlbum', TextType::class, [
            'label' => $this->translator->trans('Titre de votre album'),
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans('Titre de votre album')
            ]
        ])
        ->add('typeAlbum', EntityType::class, [
            'label' => $this->translator->trans("Type album"),
            'class' => TypeAlbum::class,
            'placeholder' => '- - -',
            'attr' => [
                'class' => 'form-select'
            ],
            'query_builder' => function(TypeAlbumRepository $typeAlbumRepository)
            {
                return $typeAlbumRepository->createQueryBuilder('t')->orderBy(('t.typeAlbum'));
            },
            'choice_label' => 'typeAlbum'
        ])
        ->add('photoAlbums', CollectionType::class, [
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
            'data_class' => Album::class,
        ]);
    }
}
