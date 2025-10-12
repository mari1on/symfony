<?php 
// src/Entity/Book.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Authorr;

#[ORM\Entity]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(type: 'boolean')]
    private bool $published = true; // ✅ new attribute

    #[ORM\ManyToOne(targetEntity: Authorr::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Authorr $authorr = null;

    // --------------------
    // Getters and setters
    // --------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;
        return $this;
    }

    public function getAuthorr(): ?Authorr
    {
        return $this->authorr;
    }

    public function setAuthorr(?Authorr $authorr): self
    {
        $this->authorr = $authorr;
        return $this;
    }
}
