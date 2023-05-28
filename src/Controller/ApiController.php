<?php

namespace App\Controller;

use App\Entity\Player;
use App\Service\CustomSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api')]
class ApiController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/game')]
    public function getGame(CustomSerializer $serializer): Response
    {
        return new Response($serializer->serialize($this->getUser()->getGame()));
    }

    #[Route('/player/{player}')]
    public function getPlayer(Player $player, CustomSerializer $serializer): Response
    {
        return new Response($serializer->serialize($player));
    }

    #[Route('/updateEntityStat/{entity}/{stat}/{id}/{value}')]
    public function updatePlayerStat (
        string $entity,
        string $stat,
        int $id,
        int $value,
        EntityManagerInterface $em,
        CustomSerializer $serializer
    ): Response
    {
        $entity = $em->getRepository('App\\Entity\\' . $entity)->find($id);

        $entity->{'set' . $stat}($entity->{'get' . $stat}() + $value);
        if ($entity->{'get' . $stat}() > $entity->{'get' . $stat . 'M'}()) {
            $entity->{'set' . $stat}($entity->{'get' . $stat . 'M'}());
        }
        $em->flush();
        return $this->json($entity->{'get' . $stat}());
    }
}