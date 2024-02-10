<?php

namespace App\Entity;

use App\Repository\PNJRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PNJRepository::class)]
class PNJ
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $PVM = null;

    #[ORM\Column(nullable: true)]
    private ?int $PV = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(nullable: true)]
    private ?int $speed = null;

    #[ORM\ManyToOne(inversedBy: 'PNJs')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Game $game = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?Token $token = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dmg_dice = null;

    #[ORM\Column(nullable: true)]
    private ?int $dmg_fixed = null;

    #[ORM\Column]
    private ?bool $isFighting = null;

    #[ORM\Column]
    private ?bool $isPlaying = null;

    #[ORM\Column(nullable: true)]
    private ?int $hit = null;

    public function __construct() {
        $this->isPlaying = 0;
        $this->isFighting = 0;
        $this->hit = 50;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPVM(): ?int
    {
        return $this->PVM;
    }

    public function setPVM(int $PVM): self
    {
        $this->PVM = $PVM;

        return $this;
    }

    public function getPV(): ?int
    {
        return $this->PV;
    }

    public function setPV(int $PV): self
    {
        $this->PV = $PV;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getDmgDice(): ?string
    {
        return $this->dmg_dice;
    }

    public function setDmgDice(?string $dmg_dice): self
    {
        $this->dmg_dice = $dmg_dice;

        return $this;
    }

    public function getDmgFixed(): ?int
    {
        return $this->dmg_fixed;
    }

    public function setDmgFixed(?int $dmg_fixed): self
    {
        $this->dmg_fixed = $dmg_fixed;

        return $this;
    }

    public function isIsFighting(): ?bool
    {
        return $this->isFighting;
    }

    public function setIsFighting(bool $isFighting): self
    {
        $this->isFighting = $isFighting;

        return $this;
    }

    public function isIsPlaying(): ?bool
    {
        return $this->isPlaying;
    }

    public function setIsPlaying(bool $isPlaying): self
    {
        $this->isPlaying = $isPlaying;

        return $this;
    }

    public function getHit(): ?int
    {
        return $this->hit;
    }

    public function setHit(?int $hit): static
    {
        $this->hit = $hit;

        return $this;
    }
}
