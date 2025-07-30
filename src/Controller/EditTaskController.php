<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class EditTaskController extends AbstractController
{   
    #[Route('team/{id}/task/edit/{task_id}', name: 'edit-task')]
    public function edit(Task $task, Request $request, EntityManagerInterface $em): Response
    {
        if (!$task) {
            throw $this->createNotFoundException('Task not found');
        }

        // Team aus Task holen, weil die Form das braucht
        $team = $task->getTeam();

        $form = $this->createForm(TaskEditFormType::class, $task, ['team' => $team]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUpdatedAt(new \DateTime());
            $em->flush();

            $this->addFlash('success', 'Task updated successfully.');

            // z.B. zurück zur Task-Übersicht
            return $this->redirectToRoute('teamPage', ['id' => $team->getId()]);
        }

        return $this->render('team/editTask.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }
}
