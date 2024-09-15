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
    // Метод buildForm определяет поля формы и настройки для каждого из них.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Выводим содержимое параметра 'formData' для отладки.
        dump($options['formData']);

        // Добавляем текстовое поле 'name' к форме.
        // - 'data' задает начальное значение из массива formData или пустую строку.
        // - 'constraints' определяет валидацию: поле не должно быть пустым.
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name', // Метка для поля.
                'data' => $options['formData']['name'] ?? '', // Значение по умолчанию.
                'required' => false, // Поле не обязательно для заполнения.
                'attr' => ['placeholder' => 'Enter your name...'], // Атрибуты для поля.
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Name should not be empty.', // Сообщение при ошибке.
                    ]),
                ]
            ])

            // Добавляем поле 'email'.
            // - Проверка на пустоту и валидация формата email.
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'data' => $options['formData']['email'] ?? '', // Значение из formData или пустое.
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email should not be empty.', // Ошибка, если поле пустое.
                    ]),
                    new Assert\Email([
                        'message' => 'Enter a valid e-mail address for Email.', // Ошибка для неверного формата email.
                    ]),
                ],
            ])

            // Добавляем кнопку отправки формы 'save'.
            ->add('save', SubmitType::class);
    }

    // Метод configureOptions позволяет настроить параметры формы.
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Задаем параметр 'formData' с пустым массивом по умолчанию.
        $resolver->setDefaults([
            'formData' => [],
        ]);

        // Указываем, что 'formData' должен быть массивом.
        $resolver->setAllowedTypes('formData', 'array');
    }
}