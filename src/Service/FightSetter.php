<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\PNJ;
use App\Repository\PlayerRepository;
use App\Repository\PNJRepository;
use Doctrine\ORM\EntityManagerInterface;

class FightSetter
{
    function __construct(
        private readonly PNJRepository $PNJRepository,
        private readonly PlayerRepository $playerRepository,
        private readonly EntityManagerInterface $em
    ) {}

    public function setPlaying (string $type, int $entity): void
    {
        if ('pnj' === $type) {
            $entity = $this->PNJRepository->find($entity);
        }

        if ('player' === $type) {
            $entity = $this->playerRepository->find($entity);
        }

        $pnj = $this->PNJRepository->findOneBy(["isPlaying" => true]);
        if ($pnj) {
            $pnj->setIsPlaying(false);
            $this->em->persist($pnj);
        }

        $player = $this->playerRepository->findOneBy(["isPlaying" => true]);
        if ($player) {
            $player->setIsPlaying(false);
            $this->em->persist($player);
        }

        $entity->setisPlaying(true);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function toggleFighting(string $type, int $entity): bool
    {
        if ('pnj' === $type) {
            $entity = $this->PNJRepository->find($entity);
        }

        if ('player' === $type) {
            $entity = $this->playerRepository->find($entity);
        }

        if ($entity->isIsFighting()) {
            $entity->setIsFighting(false);
            $entity->setIsPlaying(false);
        }
        else {
            $entity->setIsFighting(true);
        }

        $this->em->persist($entity);
        $this->em->flush();

        return $entity->isIsFighting();
    }
}