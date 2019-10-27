<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Заголовок'])
            ->add('content', TextareaType::class, ['label' => ' Текст новости'])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Дата публикации'
            ])
            ->add('author', UserSelectTextType::class, [
                'label' => 'Автор',
                'help' => 'Введите email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Поле не может быть пустым'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class
        ]);
    }
}
