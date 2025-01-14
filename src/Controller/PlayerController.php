<?php

namespace App\Controller;

use App\Form\PinType;
use App\Form\PlayerEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/character')]
    public function character(): Response
    {
        $form = $this->createForm(PlayerEditType::class, $this->getUser(), [
            'attr' => [
                'class' => 'api-form',
                'action' => '/mj/player/edit/' . $this->getUser()->getId()
            ]
        ]);
        return $this->render('player/character.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/player/map')]
    function map (): Response
    {
        $pinForm = $this->createForm(PinType::class, null, ['attr' => ['class' => 'api-form']]);

        return $this->render('player/map.html.twig', [
            'pinForm' => $pinForm
        ]);
    }
}