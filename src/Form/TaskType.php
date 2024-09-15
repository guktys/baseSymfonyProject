<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    // Метод buildForm отвечает за создание формы и добавление к ней полей.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Добавляем текстовое поле 'task' с дополнительным классом для оформления.
        $builder
            ->add('task', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group', // Класс для стилизации поля.
                ]
            ])

            // Добавляем поле 'dueDate' для выбора даты.
            ->add('dueDate', DateType::class)

            // Добавляем кнопку отправки формы 'save'.
            ->add('save', SubmitType::class);
    }

    // Метод configureOptions настраивает опции формы.
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Указываем, что форма будет работать с объектом класса Task.
        $resolver->setDefaults([
            'data_class' => Task::class, // Связывает поля формы с полями сущности Task.
        ]);
    }
}