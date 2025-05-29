<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: "post")]

class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "Id_post", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: "text")]
    private ?string $content = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $createdAt = null;

    // Relation vers l’auteur (User)
    #[ORM\ManyToOne(inversedBy: "articles")]
    #[ORM\JoinColumn(name: "Id_user", referencedColumnName: "Id_user", nullable: false)]
    private ?User $user = null;

    // Relation auto-référente (post parent)
    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: "parent_post", referencedColumnName: "Id_post", nullable: true)]
    private ?self $parentPost = null;

    // --- Getters / Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
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

    public function getParentPost(): ?self
    {
        return $this->parentPost;
    }

    public function setParentPost(?self $parentPost): static
    {
        $this->parentPost = $parentPost;
        return $this;
    }
}
