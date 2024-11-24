<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ModifierPasswordType extends AbstractType
{
    public function __construct(protected TranslatorInterface $translator)
    {
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', PasswordType::class, [
            'label' => false,
            'mapped' => false,
            'attr' => [
                'autocomplete' => 'new-password',
                'placeholder' => $this->translator->trans('Nouveau mot de passe')
            ],
            'constraints' => [
                new NotBlank([
                    'message' => $this->translator->trans('Veuillez saisir le mot de passe'),
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
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'label' => false,
            'mapped' => false,
            'required' => true,
            'attr' => [
                'placeholder' => $this->translator->trans('Confirmer le mot de passe'),
            ],
            'constraints' => [
                new NotBlank([
                    'message' => $this->translator->trans('Veuillez confirmer le mot de passe'),
                ]),
                new Length([
                    'min' => 8,
                    'minMessage' => $this->translator->trans('Votre mot de passe doit avoir 8 caractères au minimum '),
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
