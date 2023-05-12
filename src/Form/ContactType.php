<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // ->add('nom', TextType::class, [
        //     'label' => 'Vos noms et prénoms',
        //  ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => [
                    new Email([
                        'message' => "Votre email n'est pas au bon format : mail@exemple.fr"
                    ]),
                    new NotBlank([
                        'message' => "Ce champ ne peut pas être vide."
                    ]),
                ],
                // 'help' => "* min caractères : 4,
                //            * max caractères: 255,
                //            * au moins 1 caractère spécial,
                //            * au moins 1 majuscule,
                //            * au moins 1 minuscule,
                //            * au moins 1 chiffre"
            ])
            
            ->add('subject', TextType::class, [
                   'label' => 'Votre demande',
                ])

            ->add('message', TextareaType::class, [
                'label' => 'Expliquez votre demande en quelques lignes',
                'attr' => ['rows' => 5],
                'constraints' =>
                    [
                        new NotBlank([
                            'message' => "Ce champ ne peut pas être vide."
                        ]),
                    ]
            ])
                    ->add('submit', SubmitType::class, [
                    'label' => 'Envoyer',
                    'validate' => true,
                    'attr' => [
                        'class' => 'd-block col-3 my-3 mx-auto btn btn-success'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
