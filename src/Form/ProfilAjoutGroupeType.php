<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\TypeGroupe;
use App\Repository\TypeGroupeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfilAjoutGroupeType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomGroupe', TextType::class, [
            'label' => $this->translator->trans('Nom de votre groupe'),
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans('Nom de votre groupe')
            ]
        ])
        ->add('description', TextareaType::class, [
            'label' => $this->translator->trans('Description de votre groupe'),
            'attr' => [
                'class' => 'form-control',
                'placeholder' => $this->translator->trans('Description de votre groupe')
            ]
        ])
        ->add('typeGroupe', EntityType::class, [
            'label' => $this->translator->trans("Type groupe"),
            'class' => TypeGroupe::class,
            'placeholder' => '- - -',
            'attr' => [
                'class' => 'form-select'
            ],
            'query_builder' => function(TypeGroupeRepository $typeGroupeRepository)
            {
                return $typeGroupeRepository->createQueryBuilder('t')->orderBy(('t.typeGroupe'));
            },
            'choice_label' => 'typeGroupe'
        ])
        ->add('photo', FileType::class, [
            'label' => $this->translator->trans('Photo du groupe'),
            'required' => false,
            'mapped' => false,
            'attr' => [
                
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
