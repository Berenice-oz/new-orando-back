<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WalkRepository;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=WalkRepository::class)
 */
class Walk
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $startingPoint;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $endPoint;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $difficulty;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $elevation;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $maxNbPersons;

    /**
     * @ORM\Column(type="text")
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="walks")
     * 
     */
    private $area;

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

    public function getStartingPoint(): ?string
    {
        return $this->startingPoint;
    }

    public function setStartingPoint(string $startingPoint): self
    {
        $this->startingPoint = $startingPoint;

        return $this;
    }

    public function getEndPoint(): ?string
    {
        return $this->endPoint;
    }

    public function setEndPoint(string $endPoint): self
    {
        $this->endPoint = $endPoint;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getElevation(): ?int
    {
        return $this->elevation;
    }

    public function setElevation(?int $elevation): self
    {
        $this->elevation = $elevation;

        return $this;
    }

    public function getMaxNbPersons(): ?int
    {
        return $this->maxNbPersons;
    }

    public function setMaxNbPersons(?int $maxNbPersons): self
    {
        $this->maxNbPersons = $maxNbPersons;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }
}
