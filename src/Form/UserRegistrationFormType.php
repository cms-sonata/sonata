<?php

namespace App\Form;

use App\Entity\User;
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
                'constraints' => [
                    new NotBlank([
                        'message' => 'Заполните поле: email'
                    ]),
                    new Email([
                        'message' => 'Некорректный email'
                    ])
                ]
            ])
            ->add('plain_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Пароль',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Заполните поле: пароль'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Паролье должен содержать больше 6-и символов'
                    ])
                ]
            ])
            ->add('agree_terms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Я принимаю условия Пользовательского соглашения',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Необходимо принять пользовательское соглашение'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
