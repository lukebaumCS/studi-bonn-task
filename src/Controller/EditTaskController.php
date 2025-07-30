<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Team;
use App\Form\TaskEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Security\Voter\TaskVoter;

class EditTaskController extends AbstractController
{   
    #[Route('team/{team_id}/task/edit/{task_id}', name: 'edit-task')]
    public function edit($team_id, $task_id, Request $request, EntityManagerInterface $em): Response
    {

        $task = $em->getRepository(Task::class)->findOneBy([
            'id' => $task_id,
        ]);

        $team = $em->getRepository(Team::class)->findOneBy([
            'id' => $team_id
        ]);

        if ($task->getTeam() !== $team) {
            throw $this->createNotFoundException('Task does not belong to this team.');
        }

        if(!$this -> isGranted('TASK_EDIT', $task)){
            $this ->addFlash('error', 'Access Denied Due To Missing Permissions');
            return $this -> redirectToRoute('teamPage', ['id' => $team -> getId()]);
        }
        $form = $this->createForm(TaskEditFormType::class, $task, ['team' => $team]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUpdatedAt(new \DateTime());
            $team->setUpdatedAt(new \DateTime());
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
