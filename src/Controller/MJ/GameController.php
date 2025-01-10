<?php

namespace App\Controller\MJ;

use App\Form\MapType;
use App\Form\PinType;
use App\Repository\PlayerRepository;
use App\Repository\PNJRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mj')]
#[IsGranted('ROLE_MJ')]
class GameController extends AbstractController
{
    #[Route('/map')]
    function map (Request $request, EntityManagerInterface $em, FileUploader $uploader): Response
    {
        $form = $this->createForm(MapType::class);
        $pinForm = $this->createForm(PinType::class, null, ['attr' => ['class' => 'api-form']]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('map')->getData();
            $this->getUser()->getGame()->setMap($uploader->upload($image, $this->getUser()->getGame()->getMap()));
            $em->flush();
            return $this->redirectToRoute('app_mj_game_map');
        }

        return $this->render('mj/map.html.twig', [
            'form' => $form,
            'pinForm' => $pinForm
        ]);
    }
}
