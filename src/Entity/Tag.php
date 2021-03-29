<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=Walk::class, mappedBy="tags")
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

    public function setColor(?string $color): self
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
            $walk->addTag($this);
        }

        return $this;
    }

    public function removeWalk(Walk $walk): self
    {
        if ($this->walks->removeElement($walk)) {
            $walk->removeTag($this);
        }

        return $this;
    }

}
