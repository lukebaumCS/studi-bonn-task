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
    #[Route('team/{id}/task/new', name: 'new-task')]
    public function newTask(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $this -> denyAccessUnlessGranted('ROLE_USER');
        $task = new Task;
        $form = $this -> createForm(NewTaskFormType::class, $task, [
            'team' => $team,
        ]);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form->isValid()){
            $now = new \DateTime();

            $task -> setTeam($team);
            $task -> setCreatedAt($now);
            $task -> setUpdatedAt($now);
            $task -> setStatus(TaskStatus::TODO);

            $team -> addTask($task);

            $entityManager -> persist($task, $team);
            $entityManager -> flush();

            return $this -> redirectToRoute('teamPage', [
                'id' => $team -> getId(),
            ]);
        }
        return $this -> render('team/newTask.html.twig', [
            'newTaskForm' => $form,
            'team' => $team,
        ]);
    }
}
