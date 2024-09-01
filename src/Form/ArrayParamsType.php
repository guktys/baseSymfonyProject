<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class ArrayParamsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        dump($options['formData']);
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'data' => $options['formData']['name'] ?? '',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Name' . 'should not be empty.',
                    ]),]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'data' => $options['formData']['email'] ?? '',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email' . 'should not be empty.',
                    ]),
                    new Assert\Email([
                        'message' => 'Enter a valid e-mail address for ' . 'Email',
                    ]),

                ],
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'formData' => [],
        ]);

        $resolver->setAllowedTypes('formData', 'array');
    }
}