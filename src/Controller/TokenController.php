<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use App\Repository\TokenRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/token')]
class TokenController extends AbstractController
{
    #[Route('/create')]
    function create (
        Request $request,
        EntityManagerInterface $em,
        TokenRepository $tokenRepository,
        FileUploader $uploader
    ): RedirectResponse|Response
    {
        $token = new Token();
        $form = $this->createForm(TokenType::class, $token);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $form->getData();
            $image = $form->get('image')->getData();

            if ($image) {
                $token->setImage($uploader->upload($image));
            }
            $em->persist($token);
            $em->flush();

            return $this->redirectToRoute('app_token_list');
        }

        return $this->render('mj/token/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/list')]
    function list (TokenRepository $rep): Response
    {
        $tokens = $rep->findAll();
        return $this->render('mj/token/list.html.twig', [
            'tokens' => $tokens
        ]);
    }

    #[Route('/delete/{token}')]
    function delete (Token $token, EntityManagerInterface $em, Filesystem $fs): RedirectResponse
    {
        $fs->remove($token->getImage());
        $em->remove($token);
        $em->flush();

        return $this->redirectToRoute('app_token_list');
    }
}