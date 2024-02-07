<?php

namespace App\Controller;

use App\Entity\Player;
use App\Service\CustomSerializer;
use App\Service\FightSetter;
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

    #[Route("/switchPlaying/{type}/{entity}")]
    public function switchPlaying(string $type, int $entity, FightSetter $fightSetter): Response
    {
        $fightSetter->setPlaying($type, $entity);
        return $this->json(true);
    }

    #[Route("/switchFighting/{type}/{entity}")]
    public function switchFighting(string $type, int $entity, FightSetter $fightSetter): Response
    {
        return $this->json($fightSetter->toggleFighting($type, $entity));
    }
}