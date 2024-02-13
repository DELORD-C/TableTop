<?php

namespace App\Controller\MJ;

use App\Form\MapType;
use App\Repository\PlayerRepository;
use App\Repository\PNJRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'pnjs' => $PNJRepository->findBy(['game' => $this->getUser()->getGame()]),
            'players' => $playerRepository->findBy(['game' => $this->getUser()->getGame()])
        ]);
    }

    #[Route('/map')]
    function map (Request $request, EntityManagerInterface $em, FileUploader $uploader): Response
    {
        $form = $this->createForm(MapType::class);

        $form->handleRequest($request);

        dump($form->get('map')->getData());

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('map')->getData();
            dump($form->get('map')->getData());
            $this->getUser()->getGame()->setMap($uploader->upload($image, $this->getUser()->getGame()->getMap()));
            $em->flush();
            return $this->redirectToRoute('app_mj_game_map');
        }

        return $this->render('mj/map.html.twig', [
            'form' => $form
        ]);
    }
}
