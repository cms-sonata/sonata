<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $news = $options['data'] ?? null;

        $builder
            ->add('title', TextType::class, [
                'empty_data' => '',
                'label' => 'Title',
                'translation_domain' => 'news',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Field cant be empty'
                    ]),
                ]
            ])
            ->add('content', TextareaType::class, [
                'empty_data' => '',
                'label' => 'News content',
                'translation_domain' => 'news',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Field cant be empty'
                    ]),
                ]
            ])
            ->add('author', UserSelectTextType::class, [
                'disabled' => $news && $news->getId(),
                'label' => 'Author',
                'translation_domain' => 'news',
                'help' => 'Enter email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Field cant be empty'
                    ]),
                ]
            ])
        ;

        if ($options['include_published_at']) {
            $builder->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Published date',
                'translation_domain' => 'news',
                'required' => false
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
            'include_published_at' => false
        ]);
    }
}
