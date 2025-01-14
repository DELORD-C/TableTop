<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Inventory;
use App\Entity\Player;
use App\Form\GameType;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GameController extends AbstractController
{
    #[Route('/game/delete/{game}')]
    #[IsGranted('ROLE_MJ')]
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
            $inventory = new Inventory();
            $inventory->setGame($game);
            $entityManager->persist($inventory);
            $entityManager->persist($player);
            $entityManager->persist($game);
            $tokenCreator->createBaseTokens();
            $entityManager->flush();

            return $this->redirectToRoute('app_player_login');
        }

        return $this->render('game/create.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/inventory')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    function inventory(Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isGranted('ROLE_MJ')) {
            $template = 'mj/inventory.html.twig';
        }
        else {
            $template = 'player/inventory.html.twig';
        }

        return $this->render($template, [
            'inventory' => $this->getUser()->getGame()->getInventory(),
            'title' => 'Inventaire'
        ]);
    }

    #[Route('/notes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
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

        if ($this->isGranted('ROLE_MJ')) {
            $template = 'mj/form.html.twig';
        }
        else {
            $template = 'player/form.html.twig';
        }

        return $this->render($template, [
            'form' => $form->createView(),
            'title' => 'Notes'
        ]);
    }

    #[Route('/')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    function fight (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        if ($this->isGranted('ROLE_MJ')) {
            $template = 'mj/fight.html.twig';
        }
        else {
            $template = 'player/fight.html.twig';
        }
        return $this->render($template, [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }

    #[Route('/map')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    function map (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        if ($this->isGranted('ROLE_MJ')) {
            $template = 'mj/map.html.twig';
        }
        else {
            $template = 'player/map.html.twig';
        }

        return $this->render($template, [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }

    #[Route('/ambiance/{ambiance}')]
    #[IsGranted('ROLE_MJ')]
    function ambiance (string $ambiance, EntityManagerInterface $em, Request $request): Response
    {
        $game = $this->getUser()->getGame();
        $game->setAmbiance($ambiance);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}