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


class JoinTeamController extends AbstractController {


    #[Route('userPage/joinTeam/{id}', name: 'join-team')]
    public function joinTeamQuestion(int $id): Response
    {   
        return $this -> render('joinTeam.html.twig', ["id" => $id]);
    }


     #[Route('userPage/joinedTeam/{id}', name: 'joined-team')]
    public function joinedTeam(Team $team, EntityManagerInterface $entityManager): Response
    {   

        $team->addUser($user = $this->getUser());

        $entityManager -> persist($team);
        $entityManager -> flush();
        $entityManager->refresh($team);


        return $this -> render('team/teamPage.html.twig', ['team' => $team]);

    }


}