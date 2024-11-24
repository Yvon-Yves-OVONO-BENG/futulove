<?php

namespace App\Form;

use App\Entity\CigaretteVin;
use App\Entity\Corpulance;
use App\Entity\Pays;
use App\Entity\Sexe;
use App\Entity\User;
use App\Entity\Teint;
use App\Entity\CouleurYeux;
use App\Entity\CouleurCheveux;
use App\Entity\Langue;
use App\Entity\StatutMatrimonial;
use App\Repository\CigaretteVinRepository;
use App\Repository\CorpulanceRepository;
use App\Repository\PaysRepository;
use App\Repository\SexeRepository;
use App\Repository\TeintRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\CouleurYeuxRepository;
use App\Repository\CouleurCheveuxRepository;
use App\Repository\LangueRepository;
use App\Repository\StatutMatrimonialRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfilType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('pour', TextType::class, [
                'label' => 'Pour une relation',
                'attr' => [
                ]
            ])
            ->add('contact', TextType::class, [
                'label' => 'Contact(s)',
                'attr' => [
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => $this->translator->trans('Adresse'),
                'attr' => [
                ]
            ])
            ->add('animauxDeCompagnie', TextType::class, [
                'label' => $this->translator->trans('Animaux de compagnie'),
                'attr' => [
                ]
            ])
             ->add('lieuVacancePrefere', TextType::class, [
                'label' => $this->translator->trans('Interessé par'),
                'attr' => [
                ]
            ])
            ->add('photoProfile', FileType::class, [
                'label' => 'Votre photo',
                'required' => false,
                'attr' => [
                    
                ]
            ])
            // ->add('photoCouverture', FileType::class, [
            //     'label' => 'Photo couverture',
            //     'attr' => [
                    
            //     ]
            // ])
            // ->add('photoProfileFile', VichImageType::class, [
            //     'label' => false,
            //     'required' => false,
            //     'allow_delete' => true,
            //     'delete_label' => "Supprimer",
            //     'download_uri' => false,
            //     'download_label' => "Télécharger",
            //     'image_uri' => true,
            // ])
            // ->add('age', NumberType::class, [
            //     'label' => 'Votre âge',
            //     'attr' => [
                    
            //     ]
            // ])
            ->add('taille', NumberType::class, [
                'label' => 'Votre taille',
                'attr' => [
                    
                ]
            ])
            ->add('poids', NumberType::class, [
                'label' => 'Votre poids',
                'attr' => [
                    
                ]
            ])
            ->add('sexe', EntityType::class, [
                'label' => "Je suis",
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
            ->add('langue', EntityType::class, [
                'label' => $this->translator->trans('Statut matrimonial'),
                'class' => Langue::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(LangueRepository $langueRepository)
                {
                    return $langueRepository->createQueryBuilder('l')->orderBy('l.langue');
                },
                'choice_label' => 'langue'
            ])
            ->add('fume', EntityType::class, [
                'label' => $this->translator->trans('Statut matrimonial'),
                'class' => CigaretteVin::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CigaretteVinRepository $cigaretteVinRepository)
                {
                    return $cigaretteVinRepository->createQueryBuilder('c');
                },
                'choice_label' => 'cigaretteVin'
            ])
            ->add('boisson', EntityType::class, [
                'label' => $this->translator->trans('Statut matrimonial'),
                'class' => CigaretteVin::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CigaretteVinRepository $cigaretteVinRepository)
                {
                    return $cigaretteVinRepository->createQueryBuilder('c');
                },
                'choice_label' => 'cigaretteVin'
            ])
            ->add('teint', EntityType::class, [
                'label' => "Votre teint",
                'class' => Teint::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(TeintRepository $teintRepository)
                {
                    return $teintRepository->createQueryBuilder('t')->orderBy('t.teint');
                },
                'choice_label' => 'teint'
            ])
            ->add('couleurYeux', EntityType::class, [
                'label' => "Couleur des yeux",
                'class' => CouleurYeux::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CouleurYeuxRepository $couleurYeuxRepository)
                {
                    return $couleurYeuxRepository->createQueryBuilder('cy')->orderBy('cy.couleurYeux');
                },
                'choice_label' => 'couleurYeux'
            ])
            ->add('couleurCheveux', EntityType::class, [
                'label' => "Couleur des cheveux",
                'class' => CouleurCheveux::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CouleurCheveuxRepository $couleurCheveuxRepository)
                {
                    return $couleurCheveuxRepository->createQueryBuilder('cc')->orderBy('cc.couleurCheveux');
                },
                'choice_label' => 'couleurCheveux'
            ])
            ->add('corpulance', EntityType::class, [
                'label' => "Couleur des cheveux",
                'class' => Corpulance::class,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CorpulanceRepository $corpulanceRepository)
                {
                    return $corpulanceRepository->createQueryBuilder('cp')->orderBy('cp.corpulance');
                },
                'choice_label' => 'corpulance'
            ])
            ->add('pays', EntityType::class, [
                'label' => "Votre pays",
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
            ->add('dateNaissanceAt', DateType::class, [
                'label' => $this->translator->trans('Date de naissaince'),
                'widget' => 'single_text'
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
            ->add('description', TextareaType::class, [
                'label' => 'Votre description',
                'attr' => [
                    
                ]
            ])

            // ->add('envoyer', SubmitType::class, [
            //     'label' => 'Valider',
            //     'attr' => [
            //         'class' => 'lab-btn',
            //     ]
            // ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
