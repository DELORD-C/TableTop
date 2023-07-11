<?php

namespace App\Service;

use App\Entity\Token;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class TokenCreator
{
    function __construct(
        private readonly TokenRepository $tokenRepository,
        private readonly EntityManagerInterface $em
    ) {}

    function createBaseTokens (): void
    {
        if (!$this->tokenRepository->findOneBy(['name' => 'Défaut'])) {
            $default = new Token();
            $default->setName('Défaut');
            $default->setImage('default.png');
            $this->em->persist($default);
        }

        if (!$this->tokenRepository->findOneBy(['name' => 'Gobelin'])) {
            $goblin = new Token();
            $goblin->setName('Gobelin');
            $goblin->setImage('goblin.png');
            $this->em->persist($goblin);
        }
    }
}