<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamPageController extends AbstractController
{
    #[Route('team/{id}', name: 'teamPage')]
    public function teamPage(Request $request, Team $team): Response{

        $user = $this -> getUser();
        $isOwner = $user == $team -> getOwner();


        return $this -> render('team/teamPage.html.twig', [
            'team' => $team,
            'isOwner' => $isOwner,
        ]);
    }
}