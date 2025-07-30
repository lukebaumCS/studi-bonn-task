<?php
# symfony server:start
namespace App\Controller;

use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TeamRepository;
use Psr\Log\LoggerInterface;
use App\Entity\Team;
use App\Controller\User;

class UserPageController extends AbstractController
{

    #[Route('userPage', name: 'userPage')]
    public function userPage(TeamRepository $teamRepository, LoggerInterface $logger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        $myID = $user->getId();

        $otherTeams = [];
        $myTeams = [];


        $allTeams = $teamRepository->findAll();


        foreach ($allTeams as $team) {
            $owner = $team->getOwner();


            $isMyTeam = false;

            if ($owner && $owner->getId() === $myID) {
                $isMyTeam = true;
            } else {
                foreach ($team->getUsers() as $member) {
                    if ($member->getId() === $myID) {
                        $isMyTeam = true;
                        break;
                    }
                }
            }

            if ($isMyTeam) {
                $myTeams[] = ["name" => $team->getName(), "id" => $team->getId()];
            } else {
                $otherTeams[] = ["name" => $team->getName(), "id" => $team->getId()];
            }
        }


        // TODO: ADD NAME FOR USER IN TABLE
        $name = "lukas";

        return $this->render('userPage.html.twig', ['username' => $name, 'myTeams' => $myTeams, 'allTeams' => $otherTeams]);
    }
}
