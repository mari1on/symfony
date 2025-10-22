<?php

namespace App\Entity;

use App\Repository\BoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoRepository::class)]
class Bo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_bk = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'bo')]
    private ?Auth $auth = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBk(): ?int
    {
        return $this->id_bk;
    }

    public function setIdBk(int $id_bk): static
    {
        $this->id_bk = $id_bk;

        return $this;
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

    public function getAuth(): ?Auth
    {
        return $this->auth;
    }

    public function setAuth(?Auth $auth): static
    {
        $this->auth = $auth;

        return $this;
    }
}
