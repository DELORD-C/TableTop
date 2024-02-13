<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Inventory;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

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
        return $this->render('game/inventory.html.twig', [
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

        return $this->render('mj/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Notes'
        ]);
    }

    #[Route('/fight')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    function fight (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('player/fight.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }

    #[Route('/map')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    function map (PNJRepository $PNJRepository, PlayerRepository $playerRepository): Response
    {
        return $this->render('player/map.html.twig', [
            'pnjs' => $PNJRepository->findAll(),
            'players' => $playerRepository->findAll()
        ]);
    }
}