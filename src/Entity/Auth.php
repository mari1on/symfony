<?php

namespace App\Entity;

use App\Repository\AuthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: AuthRepository::class)]
class Auth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Bo>
     */
    #[ORM\OneToMany(targetEntity: Bo::class, mappedBy: 'auth')]
    private Collection $bo;

    public function __construct()
    {
        $this->bo = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Bo>
     */
    public function getBo(): Collection
    {
        return $this->bo;
    }

    public function addBo(Bo $bo): static
    {
        if (!$this->bo->contains($bo)) {
            $this->bo->add($bo);
            $bo->setAuth($this);
        }
        return $this;
    }

    public function removeBo(Bo $bo): static
    {
        if ($this->bo->removeElement($bo)) {
            if ($bo->getAuth() === $this) {
                $bo->setAuth(null);
            }
        }
        return $this;
    }
}
