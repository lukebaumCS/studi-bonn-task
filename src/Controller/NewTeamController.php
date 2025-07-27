<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Team;
use App\Form\NewTeamFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewTeamController extends AbstractController
{
    #[Route('newTeam', name: 'new-team')]
    public function newTeam(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $team = new Team;
        $form = $this -> createForm(NewTeamFormType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dd($form->getData());

            return $this -> redirectToRoute('userPage');
        }

        return $this -> render('team/newTeam.html.twig', [
            'newTeamForm' => $form,
        ]);
    }

}