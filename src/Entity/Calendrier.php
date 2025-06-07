<?php

namespace App\Entity;

use App\Repository\CalendrierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CalendrierRepository::class)]
#[ORM\Table(name: "histo_resa")]
class Calendrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_histo_resa", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "date_", type: "datetime_immutable")]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(name: "hour_", type: "time")]
    private ?\DateTimeInterface $hour = null;

    #[ORM\Column(name: "terrain_", type: "integer")]
    private ?int $terrain = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "Id_user", nullable: false)]
    private ?User $user = null;

    // --- Getters / Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(\DateTimeInterface $hour): static
    {
        $this->hour = $hour;
        return $this;
    }

    public function getTerrain(): ?int
{
    return $this->terrain;
}

    public function setTerrain(int $terrain): static
    {
        $this->terrain = $terrain;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
