<?php
# symfony server:start 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class test extends AbstractController
{
    #[Route('test')]
    public function number(): Response
    {

        return $this->render('base.html.twig');
    }

}

