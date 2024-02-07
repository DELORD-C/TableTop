<?php

namespace App\Controller\MJ;

use App\Repository\PlayerRepository;
use App\Repository\PNJRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mj')]
#[IsGranted('ROLE_MJ')]
class GameController extends AbstractController
{
    #[Route('/fight')]
    function fight (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('mj/fight.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }

    #[Route('/map')]
    function map (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('mj/map.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }
}
