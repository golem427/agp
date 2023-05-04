<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangepwFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,
        [
            'label' => 'E-mail',
            'constraints' => 
            [        
                new NotBlank([
                    'message' => "Ce champ ne peut pas être vide."
                ]),
            ]
        ])

                ->add('password', PasswordType::class,[
                'label' => 'E-mail',
                'constraints' => 
                [        
                    new NotBlank([
                        'message' => "Ce champ ne peut pas être vide."
                    ]),
                ]
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
            'data_class' => User::class,
        ]);
    }
}
