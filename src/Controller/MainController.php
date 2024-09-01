<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\ArrayParamsType;
use App\Form\TaskType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route(path: "/", name: "home")]
    public function index(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTimeImmutable('tomorrow'));

        $form = $this->createForm(TaskType::class, $task);

        $errors = '';
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $formErrors = $form->getErrors(true);
            if (count($formErrors) > 0) {
                $errors = $formErrors;
            }
            $taskNewData = $form->getData();
            $em->persist($taskNewData);
            $em->flush();
        }


        $formData = [
            'name' => 'test name',
            'email' => 'test@test.com',];

        $arrayParamsForm = $this->createForm(ArrayParamsType::class,null, [
            'formData' => $formData]);

        $arrayParamsForm->handleRequest($request);
        if ($arrayParamsForm->isSubmitted()) {
            $formErrors = $arrayParamsForm->getErrors(true);
            if (count($formErrors) > 0) {
                $errors = $formErrors;
            }else{
                return new Response("success form");
            }

        }
        return $this->render('home.html.twig', [
            'form' => $form,
            'arrayParamsForm' => $arrayParamsForm,
            'errors' => $errors,
        ]);
    }

}