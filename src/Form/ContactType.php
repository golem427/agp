<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => "Ce champ ne peut pas être vide."
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => "Votre prénom doit comporter {{ limit }} caractères minimum.",
                        'maxMessage' => "Votre prénom doit comporter {{ limit }} caractères maximum."
                    ]),
                ],
            ])


            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'constraints' => [
                    new Email([
                        'message' => "Votre email n'est pas au bon format : mail@exemple.fr"
                    ]),
                    new NotBlank([
                        'message' => "Ce champ ne peut pas être vide."
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 180,
                        'minMessage' => "Votre email doit comporter {{ limit }} caractères minimum.",
                        'maxMessage' => "Votre email doit comporter {{ limit }} caractères maximum."
                    ]),
                ],
                // 'help' => "* min caractères : 4,
                //            * max caractères: 255,
                //            * au moins 1 caractère spécial,
                //            * au moins 1 majuscule,
                //            * au moins 1 minuscule,
                //            * au moins 1 chiffre"
            ])


            ->add(
                'telephone',
                TextType::class,
                [
                    'label' => 'Téléphone',
                    'constraints' =>
                    [
                        new NotBlank([
                            'message' => "Ce champ ne peut pas être vide."
                        ]),
                        new Length([
                            'min' => 10,
                            'max' => 22,
                        ]),
                    ]
                ])

            ->add('message', TextareaType::class, [
                'attr' => ['rows' => 5]
            ])

            ->add('createdAt', DateTimeType::class,
            [   'label' => 'Date (jj/mm/AAAA)',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'validate' => false,
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
