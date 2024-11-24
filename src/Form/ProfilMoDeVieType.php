<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\CigaretteVin;
use Symfony\Component\Form\AbstractType;
use App\Repository\CigaretteVinRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfilMoDeVieType extends AbstractType
{   
    public function __construct(
        protected TranslatorInterface $translator
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animauxDeCompagnie', TextType::class, [
                'label' => $this->translator->trans('Animaux de compagnie'),
                'attr' => [
                ]
            ])
            ->add('lieuVacancePrefere', TextType::class, [
                'label' => $this->translator->trans('Lieu(x) de vacances preféré(s)'),
                'attr' => [
                ]
            ])
            ->add('pour', TextType::class, [
                'label' => $this->translator->trans('Vous êtes sur ce site pour '),
                'attr' => [
                ]
            ])
            ->add('fume', EntityType::class, [
                'label' => $this->translator->trans('Vous fumez ?'),
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
                'label' => $this->translator->trans('Alcool'),
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
            ->add('langue', ChoiceType::class, [
                'choices' => $options['langues'],
                'label' => $this->translator->trans('Langues parlées'),
                'multiple' => true,
                'required' => false,
                'expanded' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'select-langues',
                ]
            ])
            // ->add('langue', EntityType::class, [
            //     'label' => $this->translator->trans('Langues parlées'),
            //     'class' => Langue::class,'multiple' => true,
            //     'required' => false,
            //     'expanded' => false,
            //     'placeholder' => '- - -',
            //     'attr' => [
            //         'class' => 'form-select'
            //     ],
            //     'query_builder' => function(LangueRepository $langueRepository)
            //     {
            //         return $langueRepository->createQueryBuilder('l')->orderBy('l.langue');
            //     },
            //     'choice_label' => 'langue'
            // ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'langues' => [],
        ]);
    }
}
