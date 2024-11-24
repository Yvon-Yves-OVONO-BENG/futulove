<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Sexe;
use App\Entity\User;
use App\Entity\StatutMatrimonial;
use App\Repository\PaysRepository;
use App\Repository\SexeRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\StatutMatrimonialRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfilInformationsDeBaseType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => $this->translator->trans('Votre nom'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('sexe', EntityType::class, [
                'label' => $this->translator->trans("Je suis"),
                'class' => Sexe::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(SexeRepository $sexeRepository)
                {
                    return $sexeRepository->createQueryBuilder('s');
                },
                'choice_label' => 'sexe'
            ])
            ->add('aLaRechercheDe', EntityType::class, [
                'label' => "Je cherche",
                'class' => Sexe::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(SexeRepository $sexeRepository)
                {
                    return $sexeRepository->createQueryBuilder('s');
                },
                'choice_label' => 'sexe'
            ])
            ->add('statutMatrimonial', EntityType::class, [
                'label' => $this->translator->trans('Statut matrimonial'),
                'class' => StatutMatrimonial::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(StatutMatrimonialRepository $statutMatrimonialRepository)
                {
                    return $statutMatrimonialRepository->createQueryBuilder('s');
                },
                'choice_label' => 'statutMatrimonial'
            ])

            ->add('dateNaissanceAt', DateType::class, [
                'label' => $this->translator->trans('Date de naissaince'),
                'widget' => 'single_text'
            ])
            
            ->add('contact', TextType::class, [
                'label' => $this->translator->trans('Contact(s)'),
                'attr' => [
                ]
            ])
            ->add('region', TextType::class, [
                'label' => $this->translator->trans('Région'),
                'attr' => [
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('departement', TextType::class, [
                'label' => $this->translator->trans('Département'),
                'attr' => [
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => $this->translator->trans('Ville'),
                'attr' => [
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => $this->translator->trans('Adresse'),
                'attr' => [
                ]
            ])
            ->add('pays', EntityType::class, [
                'label' => $this->translator->trans("Votre pays"),
                'class' => Pays::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(PaysRepository $paysRepository)
                {
                    return $paysRepository->createQueryBuilder('p')->orderBy('p.pays');
                },
                'choice_label' => 'pays'
            ])
            
            ->add('photoProfile', FileType::class, [
                'label' => $this->translator->trans('Votre photo'),
                'required' => false,
                'data_class' => null,
                'attr' => [
                    
                ]
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
