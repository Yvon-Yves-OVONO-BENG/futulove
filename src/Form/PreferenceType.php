<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Sexe;
use App\Entity\Teint;
use App\Entity\Corpulance;
use App\Entity\Preference;
use App\Entity\CouleurYeux;
use App\Entity\CigaretteVin;
use App\Entity\CouleurCheveux;
use App\Repository\PaysRepository;
use App\Repository\SexeRepository;
use App\Repository\TeintRepository;
use App\Repository\CorpulanceRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\CouleurYeuxRepository;
use App\Repository\CigaretteVinRepository;
use App\Repository\CouleurCheveuxRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PreferenceType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    ){}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region', TextType::class, [
                'label' => $this->translator->trans('Sa région'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('departement', TextType::class, [
                'label' => $this->translator->trans('Son département'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => $this->translator->trans('Sa ville'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('taille', NumberType::class, [
                'label' => $this->translator->trans('Sa taille (en cm)'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('poids', NumberType::class, [
                'label' => $this->translator->trans('Son poids (en kg)'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('langue', TextType::class, [
                'label' => $this->translator->trans('Sa/ses langue(s)'),
                'required' => false,
                'attr' => [
                ]
            ])
            ->add('genre', EntityType::class, [
                'label' => "Je cherche",
                'required' => false,
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
            ->add('pays', EntityType::class, [
                'label' => $this->translator->trans("Son pays"),
                'class' => Pays::class,
                'required' => false,
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
            ->add('corpulance', EntityType::class, [
                'label' => $this->translator->trans("Corpulance"),
                'class' => Corpulance::class,
                'required' => false,
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
            ->add('couleurYeux', EntityType::class, [
                'label' => $this->translator->trans("Couleur des yeux"),
                'class' => CouleurYeux::class,
                'required' => false,
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
                'label' => $this->translator->trans("Couleur des cheveux"),
                'class' => CouleurCheveux::class,
                'placeholder' => '- - -',
                'required' => false,
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(CouleurCheveuxRepository $couleurCheveuxRepository)
                {
                    return $couleurCheveuxRepository->createQueryBuilder('cc')->orderBy('cc.couleurCheveux');
                },
                'choice_label' => 'couleurCheveux'
            ])
            ->add('teint', EntityType::class, [
                'label' => $this->translator->trans("Votre teint"),
                'class' => Teint::class,
                'required' => false,
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
            ->add('cigarette', EntityType::class, [
                'label' => $this->translator->trans('Vous fumez ?'),
                'class' => CigaretteVin::class,
                'required' => false,
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
            ->add('vin', EntityType::class, [
                'label' => $this->translator->trans('Alcool'),
                'class' => CigaretteVin::class,
                'required' => false,
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
            ->add('animauxDeCompagnie', TextType::class, [
                'label' => $this->translator->trans('Animaux de compagnie'),
                'required' => false,
                'attr' => [
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
