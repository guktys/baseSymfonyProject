<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\ArrayParamsType;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    // Маршрут для главной страницы сайта
    #[Route(path: "/", name: "home")]
    public function index(Request $request, EntityManagerInterface $em)
    {
        // Создаем новый объект Task и задаем начальные данные
        $task = new Task();
        $task->setTask('Write a blog post'); // Устанавливаем текст задачи
        $task->setDueDate(new \DateTimeImmutable('tomorrow')); // Устанавливаем дату выполнения на завтра

        // Создаем форму TaskType и связываем её с объектом Task
        $form = $this->createForm(TaskType::class, $task);

        $errors = ''; // Переменная для хранения ошибок формы

        // Обрабатываем запрос на отправку формы
        $form->handleRequest($request);

        // Проверяем, была ли форма отправлена
        if ($form->isSubmitted()) {
            $formErrors = $form->getErrors(true); // Получаем ошибки формы
            if (count($formErrors) > 0) {
                $errors = $formErrors; // Если есть ошибки, сохраняем их в переменную
            }
            $taskNewData = $form->getData(); // Получаем данные формы
            $em->persist($taskNewData); // Сохраняем данные в базу данных
            $em->flush(); // Выполняем сохранение
        }

        // Данные для второй формы (ArrayParamsType)
        $formData = [
            'name' => 'test name', // Пример имени
            'email' => 'test@test.com', // Пример email
        ];

        // Создаем форму ArrayParamsType с передачей данных
        $arrayParamsForm = $this->createForm(ArrayParamsType::class, null, [
            'formData' => $formData
        ]);

        // Обрабатываем запрос на отправку формы ArrayParamsType
        $arrayParamsForm->handleRequest($request);
        if ($arrayParamsForm->isSubmitted()) {
            $formErrors = $arrayParamsForm->getErrors(true); // Получаем ошибки формы
            if (count($formErrors) > 0) {
                $errors = $formErrors; // Если есть ошибки, сохраняем их в переменную
            } else {
                // Если ошибок нет, возвращаем успешный ответ
                return new Response("success form");
            }
        }

        // Возвращаем шаблон с формами и ошибками
        return $this->render('home.html.twig', [
            'form' => $form, // Форма TaskType
            'arrayParamsForm' => $arrayParamsForm, // Форма ArrayParamsType
            'errors' => $errors, // Ошибки
        ]);
    }
}