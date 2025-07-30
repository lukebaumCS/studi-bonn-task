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

        $user = $this->getUser();
        $myID = $user->getId();

        $otherTeams = [];
        $myTeams = [];

        $allTeams = $teamRepository->findAll();


        foreach ($allTeams as $team) {
        
            $owner = $team->getOwner();

            foreach ($team->getUsers() as $member) {
                if ($member->getId() == $myID or $owner->getId() == $myID) {
                    $myTeams[] = ["name" => $team->getName()];
                    break;
                }
                else {
                    $otherTeams[] = ["name" => $team->getName()];
                    break;
                }
            }
        }

        // TODO: ADD NAME FOR USER IN TABLE 
        $name = "lukas";
        
        return $this->render('userPage.html.twig', ['username' => $name, 'myTeams' => $myTeams, 'allTeams' => $otherTeams]);
    }
}