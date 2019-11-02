<?php

namespace App\Form;

use App\Form\Model\UserRegistrationFormModel;
use App\Validator\UniqueUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email address',
                'translation_domain' => 'main',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your: email'
                    ]),
                    new Email([
                        'message' => 'Incorrect email'
                    ]),
                    new UniqueUser([
                        'message' => 'Duplicate email'
                    ])
                ]
            ])
            ->add('plain_password', PasswordType::class, [
                'translation_domain' => 'main',
                'label' => 'Password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your: password'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Not enough password length'
                    ])
                ]
            ])
            ->add('agree_terms', CheckboxType::class, [
                'constraints' => [
                    new IsTrue([
                        'message' => 'Need agree terms'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
        ]);
    }
}
