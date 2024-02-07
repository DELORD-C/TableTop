<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Form\GameType;
use App\Form\InventoryType;
use App\Form\NotesType;
use App\Repository\PlayerRepository;
use App\Repository\PNJRepository;
use App\Service\TokenCreator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game/delete/{game}')]
    function delete (Game $game, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($game);
        $em->flush();

        return $this->redirectToRoute('app_player_login');
    }

    #[Route('/game/create')]
    public function create(
        Request $request,
        UserPasswordHasherInterface $playerPasswordHasher,
        EntityManagerInterface $entityManager,
        TokenCreator $tokenCreator
    ): Response
    {
        $player = new Player();
        $form = $this->createForm(GameType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player->setPassword(
                $playerPasswordHasher->hashPassword(
                    $player,
                    $form->get('plainPassword')->getData()
                )
            );
            $player->setRoles(['ROLE_MJ']);
            $game = new Game();
            $game->addPlayer($player);
            $game->setName($form->get('game')->getData());
            $game->setPassword($form->get('game_password')->getData());
            $player->setGame($game);
            $entityManager->persist($player);
            $entityManager->persist($game);
            $tokenCreator->createBaseTokens();
            $entityManager->flush();

            return $this->redirectToRoute('app_default_home');
        }

        return $this->render('game/create.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/inventory')]
    function inventory(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(InventoryType::class, $this->getUser()->getGame(), ['attr' => [
            'class' => 'api-form form-full',
            'update' => 'game'
        ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("app_game_inventory");
        }

        return $this->render('mj/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Inventaire'
        ]);
    }

    #[Route('/notes')]
    function notes(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NotesType::class, $this->getUser()->getGame(), ['attr' => [
            'class' => 'api-form form-full',
            'update' => 'game'
        ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("app_game_notes");
        }

        return $this->render('mj/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Notes'
        ]);
    }

    #[Route('/fight')]
    function fight (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('player/fight.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }

    #[Route('/map')]
    function map (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('player/map.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }
}