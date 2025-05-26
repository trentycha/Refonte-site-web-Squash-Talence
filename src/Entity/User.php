<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user_")]
#[ORM\UniqueConstraint(name: "UNIQ_EMAIL", fields: ["email"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_user", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "name", length: 100)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(name: "firstname", length: 100)]
    #[Assert\NotBlank]
    private ?string $firstname = null;

    #[ORM\Column(name: "email", length: 100)]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column(name: "phone", length: 50)]
    private ?string $phone = null;

    #[ORM\Column(name: "password", length: 100)]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(name: "isSubscribed", type: "boolean")]
    private bool $isSubscribed = false;

    // --- Getters / Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function isSubscribed(): bool
    {
        return $this->isSubscribed;
    }

    public function setIsSubscribed(bool $isSubscribed): static
    {
        $this->isSubscribed = $isSubscribed;
        return $this;
    }

    // --- Implémentations UserInterface ---

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    
    }
}
