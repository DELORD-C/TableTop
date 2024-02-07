<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    function home (): Response
    {
        if ($this->isGranted('ROLE_MJ')) {
            return $this->redirectToRoute('app_mj_game_fight');
        }
        else {
            return $this->redirectToRoute('app_game_fight');
        }
    }
}