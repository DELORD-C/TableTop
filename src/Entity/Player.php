<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $race = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $class = null;

    #[ORM\Column(nullable: true)]
    private ?int $PVM = null;

    #[ORM\Column(nullable: true)]
    private ?int $PV = null;

    #[ORM\Column(nullable: true)]
    private ?int $PCM = null;

    #[ORM\Column(nullable: true)]
    private ?int $PC = null;

    #[ORM\Column(nullable: true)]
    private ?int $PMM = null;

    #[ORM\Column(nullable: true)]
    private ?int $PM = null;

    #[ORM\Column(nullable: true)]
    private ?int $PD = null;

    #[ORM\Column(nullable: true)]
    private ?int $lvl = null;

    #[ORM\Column(length: 90000, nullable: true)]
    private ?string $lore = null;

    #[ORM\Column(length: 90000, nullable: true)]
    private ?string $activ = null;

    #[ORM\Column(length: 90000, nullable: true)]
    private ?string $passiv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dmg_dice = null;

    #[ORM\Column(nullable: true)]
    private ?int $dmg_fixed = null;

    #[ORM\Column(nullable: true)]
    private ?int $intel = null;

    #[ORM\Column(nullable: true)]
    private ?int $strength = null;

    #[ORM\Column(nullable: true)]
    private ?int $social = null;

    #[ORM\Column(nullable: true)]
    private ?int $perception = null;

    #[ORM\Column(nullable: true)]
    private ?int $speed = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Game $game = null;

    #[ORM\ManyToOne]
    private ?Token $token = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
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

    public function getPCM(): ?int
    {
        return $this->PCM;
    }

    public function setPCM(int $PCM): self
    {
        $this->PCM = $PCM;

        return $this;
    }

    public function getPC(): ?int
    {
        return $this->PC;
    }

    public function setPC(?int $PC): self
    {
        $this->PC = $PC;

        return $this;
    }

    public function getPMM(): ?int
    {
        return $this->PMM;
    }

    public function setPMM(int $PMM): self
    {
        $this->PMM = $PMM;

        return $this;
    }

    public function getPM(): ?int
    {
        return $this->PM;
    }

    public function setPM(?int $PM): self
    {
        $this->PM = $PM;

        return $this;
    }

    public function getPD(): ?int
    {
        return $this->PD;
    }

    public function setPD(int $PD): self
    {
        $this->PD = $PD;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(?string $lore): self
    {
        $this->lore = $lore;

        return $this;
    }

    public function getActiv(): ?string
    {
        return $this->activ;
    }

    public function setActiv(?string $activ): self
    {
        $this->activ = $activ;

        return $this;
    }

    public function getPassiv(): ?string
    {
        return $this->passiv;
    }

    public function setPassiv(?string $passiv): self
    {
        $this->passiv = $passiv;

        return $this;
    }

    public function getDmgDice(): ?string
    {
        return $this->dmg_dice;
    }

    public function setDmgDice(string $dmg_dice): self
    {
        $this->dmg_dice = $dmg_dice;

        return $this;
    }

    public function getDmgFixed(): ?int
    {
        return $this->dmg_fixed;
    }

    public function setDmgFixed(int $dmg_fixed): self
    {
        $this->dmg_fixed = $dmg_fixed;

        return $this;
    }

    public function getIntel(): ?int
    {
        return $this->intel;
    }

    public function setIntel(int $intel): self
    {
        $this->intel = $intel;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getSocial(): ?int
    {
        return $this->social;
    }

    public function setSocial(int $social): self
    {
        $this->social = $social;

        return $this;
    }

    public function getPerception(): ?int
    {
        return $this->perception;
    }

    public function setPerception(int $perception): self
    {
        $this->perception = $perception;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
}
