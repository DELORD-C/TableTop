<?php

namespace App\Controller\MJ;

use App\Entity\PNJ;
use App\Form\PNJType;
use App\Repository\PNJRepository;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pnj')]
class PNJController extends AbstractController
{
    #[Route('/create')]
    function create (Request $request, EntityManagerInterface $em, TokenRepository $tokenRepository): Response
    {
        $pnj = new PNJ();
        $form = $this->createForm(PNJType::class, $pnj);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $game = $this->getUser()->getGame();
            $pnj = $form->getData();
            $pnj->setGame($game);
            $em->persist($pnj);
            $em->flush();
            return $this->redirectToRoute('app_mj_pnj_list');
        }

        return $this->render('mj/PNJ/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/list')]
    function list (PNJRepository $rep): Response
    {
        $pnjs = $rep->findAll();
        return $this->render('mj/PNJ/list.html.twig', [
            'pnjs' => $pnjs
        ]);
    }

    #[Route('/edit/{pnj}')]
    function edit (PNJ $pnj, EntityManagerInterface $em, Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(PNJType::class, $pnj, ['attr' => [
            'class' => 'api-form',
            'update' => '/pnj/get/' . $pnj->getId()
        ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pnj = $form->getData();
            $em->persist($pnj);
            $em->flush();
            return $this->redirectToRoute('app_mj_pnj_list');
        }

        return $this->render('mj/pnj/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{pnj}')]
    function delete (Pnj $pnj, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($pnj);
        $em->flush();

        return $this->redirectToRoute('app_mj_pnj_list');
    }

    #[Route('/duplicate/{pnj}')]
    function duplicate(PNJ $pnj, EntityManagerInterface $em): RedirectResponse
    {
        $newPnj = clone $pnj;
        $newPnj->setName($pnj->getName() . '-bis');
        $em->persist($newPnj);
        $em->flush();

        return $this->redirectToRoute('app_mj_pnj_list');
    }
}