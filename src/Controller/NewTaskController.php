<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Form\NewTaskFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewTaskController extends AbstractController
{
    #[Route('team/newTask', name: 'new-task')]
    public function newTask(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task;
        $form = $this -> createForm(NewTaskFormType::class, $task);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form->isValid()){
            $now = new \DateTime();

            $task -> setCreatedAt($now);
            $task -> setUpdatedAt($now);

            $task -> setStatus(TaskStatus::TODO);
            #TODO: add team dafür müssen wir die team variable übergeben"

            dd($task);

            $entityManager -> persist($task);
            $entityManager -> flush();

            return $this -> redirectToRoute('teamPage');
        }
        return $this -> render('team/newTask.html.twig', [
            'newTaskForm' => $form,
        ]);
    }
}
