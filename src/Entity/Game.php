<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90000, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(length: 90000, nullable: true)]
    private ?string $inventory = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $map = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Player::class, orphanRemoval: true)]
    private Collection $players;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Pin::class, orphanRemoval: true)]
    private Collection $pins;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: PNJ::class, orphanRemoval: true)]
    private Collection $PNJs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->pins = new ArrayCollection();
        $this->PNJs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->notes;
    }

    public function setNote(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getInventory(): ?string
    {
        return $this->inventory;
    }

    public function setInventory(string $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(?string $map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setGame($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getGame() === $this) {
                $player->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pin>
     */
    public function getPins(): Collection
    {
        return $this->pins;
    }

    public function addPin(Pin $pin): self
    {
        if (!$this->pins->contains($pin)) {
            $this->pins->add($pin);
            $pin->setGame($this);
        }

        return $this;
    }

    public function removePin(Pin $pin): self
    {
        if ($this->pins->removeElement($pin)) {
            // set the owning side to null (unless already changed)
            if ($pin->getGame() === $this) {
                $pin->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PNJ>
     */
    public function getPNJs(): Collection
    {
        return $this->PNJs;
    }

    public function addPNJ(PNJ $pNJ): self
    {
        if (!$this->PNJs->contains($pNJ)) {
            $this->PNJs->add($pNJ);
            $pNJ->setGame($this);
        }

        return $this;
    }

    public function removePNJ(PNJ $pNJ): self
    {
        if ($this->PNJs->removeElement($pNJ)) {
            // set the owning side to null (unless already changed)
            if ($pNJ->getGame() === $this) {
                $pNJ->setGame(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
