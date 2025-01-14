<?php

namespace App\Controller\MJ;

use App\Entity\Music;
use App\Form\MusicType;
use App\Repository\MusicRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mj/music')]
#[IsGranted('ROLE_MJ')]
class MusicController extends AbstractController
{
    #[Route('/create')]
    function create (
        Request $request,
        EntityManagerInterface $em,
        MusicRepository $musicRepository,
        FileUploader $uploader
    ): RedirectResponse|Response
    {
        $music = new Music();
        $form = $this->createForm(MusicType::class, $music);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $songs = $form->get('file')->getData();
            $type = $form->get('list')->getData();
            if ($songs) {
                foreach ($songs as $song) {
                    $music = new Music();
                    $music->setFile($uploader->upload($song, null, 'music'));
                    $music->setList($type);
                    $em->persist($music);
                }
            }
            $em->flush();

            return $this->redirectToRoute('app_mj_music_list');
        }

        return $this->render('mj/music/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/list')]
    function list (MusicRepository $rep): Response
    {
        $chill = $rep->findBy(['list' => 0]);
        $suspense = $rep->findBy(['list' => 1]);
        $combat = $rep->findBy(['list' => 2]);
        return $this->render('mj/music/list.html.twig', [
            'chill' => $chill,
            'suspense' => $suspense,
            'combat' => $combat
        ]);
    }

    #[Route('/delete/{music}')]
    function delete (Music $music, EntityManagerInterface $em, FileUploader $uploader): RedirectResponse
    {
        $uploader->remove($music->getFile(), 'music');
        $em->remove($music);
        $em->flush();

        return $this->redirectToRoute('app_mj_music_list');
    }
}