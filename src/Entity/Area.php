<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AreaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AreaRepository::class)
 */
class Area
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"api_area_read", "api_walks_read", "api_walks_read_item", "api_users_read_item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"api_area_read", "api_walks_read", "api_walks_read_item", "api_users_read_item"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     * 
     * @Groups({"api_area_read", "api_walks_read", "api_walks_read_item", "api_users_read_item"})
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=Walk::class, mappedBy="area")
     * @Groups("api_area_read_item")
     */
    private $walks;

    public function __construct()
    {
        $this->walks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Walk[]
     */
    public function getWalks(): Collection
    {
        return $this->walks;
    }

    public function addWalk(Walk $walk): self
    {
        if (!$this->walks->contains($walk)) {
            $this->walks[] = $walk;
            $walk->setArea($this);
        }

        return $this;
    }

    public function removeWalk(Walk $walk): self
    {
        if ($this->walks->removeElement($walk)) {
            // set the owning side to null (unless already changed)
            if ($walk->getArea() === $this) {
                $walk->setArea(null);
            }
        }

        return $this;
    }
}
