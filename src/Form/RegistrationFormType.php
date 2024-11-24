<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Sexe;
use App\Entity\User;
use App\Repository\PaysRepository;
use App\Repository\SexeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function __construct(protected TranslatorInterface $translator)
    {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                // 'mapped' => false,
                'label' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => $this->translator->trans('Votre mot de passe')
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => $this->translator->trans('Votre mot de passe doit avoir 8 caractères au minimum '),
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Confirmer votre mot de passe')
                ],
            ])

            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Votre nom')
                ],
            ])
            ->add('pays', EntityType::class, [
                'label' => $this->translator->trans('Pays'),
                'class' => Pays::class,
                'placeholder' => $this->translator->trans('Sélectionnez votre pays'),
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(PaysRepository $paysRepository)
                {
                    return $paysRepository->createQueryBuilder('p')->orderBy('p.pays');
                },
                'choice_label' => 'pays'
            ])
            ->add('sexe', EntityType::class, [
                'label' => $this->translator->trans('Pays'),
                'class' => Sexe::class,
                'placeholder' => $this->translator->trans('Sélectionnez votre genre'),
                'attr' => [
                    'class' => 'form-select'
                ],
                'query_builder' => function(SexeRepository $sexeRepository)
                {
                    return $sexeRepository->createQueryBuilder('s')->orderBy('s.sexe');
                },
                'choice_label' => 'sexe'
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
