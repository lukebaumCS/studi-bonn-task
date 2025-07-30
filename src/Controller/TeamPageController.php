<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Attribute\Route;
use Psr\Log\LoggerInterface;

class TeamPageController extends AbstractController
{
    #[Route('teamPage/{id}', 'teamPage')]
    public function teamPage(Request $request, Team $team, LoggerInterface $logger): Response{

        $user = $this -> getUser();
        $tasks = $team -> getTasks() -> toArray();

        usort($tasks, fn(Task $a, Task $b) =>
            ($b->getUser() === $user) <=> ($a->getUser() === $user)
        );
        
        return $this -> render('team/teamPage.html.twig', [
            'team' => $team,
            'tasks' => $tasks,
        ]);
    }
}