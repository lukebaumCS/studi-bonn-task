<?php
# symfony server:start
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestingTwigTemplates extends AbstractController
{
    #[Route('userPage', name: 'userPage')]
    public function userPage(): Response
    {
        $this -> denyAccessUnlessGranted('ROLE_USER');
        $name = "lukas";
        $myTeams = [
            ['name' => 'Team Alpha'],
            ['name' => 'Team Beta'],
            ['name' => 'Team Gamma'],
        ];
        $allTeams = [
            ['name' => 'Team Ford'],
            ['name' => 'Team Porsche'],
            ['name' => 'Team BMW'],
        ];

        return $this->render('userPage.html.twig', ['username' => $name, 'myTeams' => $myTeams, 'allTeams' => $allTeams]);
    }


        #[Route('teamPage/{id}', name: 'teamPage')]
        public function teamPage(): Response
        {
            $this -> denyAccessUnlessGranted('ROLE_USER');
            $teamName = "Team Bravo";
            $myTasks = [
                ['name' => 'Login erstellen', 'status' => 'Done'],
                ['name' => 'Twig template erstellen', 'status' => 'In progress'],
                ['name' => 'Joining a team', 'status' => 'Todo'],
            ];
            $allUsers = [
                ['name' => 'Lukas'],
                ['name' => 'Imene'],
                ['name' => 'Mauritz'],
                ['name' => 'Torgöö'],
            ];

            return $this->render('teamPage.html.twig', ['teamName' => $teamName, 'myTasks' => $myTasks, 'allUsers' => $allUsers]);
        }



}

