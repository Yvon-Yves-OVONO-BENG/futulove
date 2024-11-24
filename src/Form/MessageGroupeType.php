<?php

namespace App\Form;

use App\Entity\MessageGroupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageGroupeType extends AbstractType
{
    public function __construct(
        protected TranslatorInterface $translator
    )
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messageGroupe', TextareaType::class, [
                'label' => $this->translator->trans('Votre message'),
                'required' => true,
                'attr' => [
                    'placeholder' => $this->translator->trans("Votre message"),
                ]
            ])
            ->add('fichierMessageGroupes', CollectionType::class, [
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
            'data_class' => MessageGroupe::class,
        ]);
    }
}
