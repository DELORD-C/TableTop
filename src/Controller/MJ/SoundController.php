<?php

namespace App\Controller\MJ;

use App\Entity\Sound;
use App\Form\SoundType;
use App\Repository\SoundRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mj/sound')]
#[IsGranted('ROLE_MJ')]
class SoundController extends AbstractController
{
    #[Route('/create')]
    function create (
        Request $request,
        EntityManagerInterface $em,
        SoundRepository $soundRepository,
        FileUploader $uploader
    ): RedirectResponse|Response
    {
        $sound = new Sound();
        $form = $this->createForm(SoundType::class, $sound);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $songs = $form->get('file')->getData();
            $icon = $form->get('icon')->getData();
            if ($songs) {
                foreach ($songs as $song) {
                    $sound = new Sound();
                    $sound->setFile($uploader->upload($song, null, 'sound'));
                    $sound->setIcon($icon);
                    $sound->setGame($this->getUser()->getGame());
                    $em->persist($sound);
                }
            }
            $em->flush();

            return $this->redirectToRoute('app_mj_sound_list');
        }

        return $this->render('mj/sound/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/list')]
    function list (SoundRepository $rep): Response
    {
        return $this->render('mj/sound/list.html.twig', [
            'sounds' => $rep->findAll()
        ]);
    }

    #[Route('/delete/{sound}')]
    function delete (Sound $sound, EntityManagerInterface $em, FileUploader $uploader): RedirectResponse
    {
        $uploader->remove($sound->getFile(), 'sound');
        $em->remove($sound);
        $em->flush();

        return $this->redirectToRoute('app_mj_sound_list');
    }
}