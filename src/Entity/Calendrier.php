<?php

namespace App\Entity;

use App\Repository\CalendrierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(name: "time_", type: "time")]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(name: "court", type: "integer")]
    private ?int $court = null;

    #[ORM\Column(name: "status", type: "boolean")]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: "reservations")]
    #[ORM\JoinColumn(name: "Id_user", referencedColumnName: "Id_user", nullable: true)]
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

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;
        return $this;
    }

    public function getCourt(): ?int
    {
        return $this->court;
    }

    public function setCourt(int $court): static
    {
        $this->court = $court;
        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;
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
