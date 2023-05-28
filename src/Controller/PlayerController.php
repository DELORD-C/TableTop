<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Token;
use App\Form\PlayerEditType;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PlayerController extends AbstractController
{
    #[Route('/login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('player/login.html.twig', [
            'error' => $error
        ]);
    }

    #[Route('/logout')]
    public function logout() {}

    #[Route('/player/create')]
    function create (
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $playerPasswordHasher,
        TokenRepository $tokenRepository
    ) : Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game = $this->getUser()->getGame();
            $player = $form->getData();
            $player->setPassword(
                $playerPasswordHasher->hashPassword(
                    $player,
                    $game->getPassword()
                )
            );
            $player->setGame($game);
            $player->setToken($tokenRepository->findOneBy(['name' => 'Défaut']));
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('app_player_list');
        }

        return $this->render('mj/player/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/player/list')]
    function list (PlayerRepository $rep): Response
    {
        $players = $rep->findAll();
        return $this->render('mj/player/list.html.twig', [
            'players' => $players
        ]);
    }

    #[Route('/player/edit/{player}')]
    function edit (Player $player, EntityManagerInterface $em, Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(PlayerEditType::class, $player, ['attr' => [
            'class' => 'api-form',
            'update' => 'player/' . $player->getId()
        ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('app_player_list');
        }

        return $this->render('mj/player/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{player}')]
    function delete (Player $player, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($player);
        $em->flush();

        return $this->redirectToRoute('app_player_list');
    }
}