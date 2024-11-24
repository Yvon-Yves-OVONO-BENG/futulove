<?php

namespace App\Form;

use App\Entity\Corpulance;
use App\Entity\User;
use App\Entity\Teint;
use App\Entity\CouleurYeux;
use App\Entity\CouleurCheveux;
use App\Repository\CorpulanceRepository;
use App\Repository\TeintRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\CouleurYeuxRepository;
use App\Repository\CouleurCheveuxRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfilInformationsPhysiquesType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taille', NumberType::class, [
                'label' => $this->translator->trans('Votre taille (en cm)'),
                'attr' => [
                    
                ]
            ])
            ->add('poids', NumberType::class, [
                'label' => $this->translator->trans('Votre poids (en kg)'),
                'attr' => [
                ]
            ])
            ->add('teint', EntityType::class, [
                'label' => $this->translator->trans("Votre teint"),
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
                'label' => $this->translator->trans("Couleur des yeux"),
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
                'label' => $this->translator->trans("Couleur des cheveux"),
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
                'label' => $this->translator->trans("Corpulance"),
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
