<?php

namespace App\Entity;

use App\Entity\Participant;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WalkRepository;
use App\DBAL\Types\WalkDifficultyType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity(repositoryClass=WalkRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Walk
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_walks_read", "api_walks_read_item", "api_users_read_item", "api_area_read_item", "api_participant_check"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_walks_read", "api_walks_read_item", "api_users_read_item", "api_area_read_item"})
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item"})
     * @Assert\NotBlank
     */
    private $startingPoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item"})
     * 
     */
    private $endPoint;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"api_walks_read", "api_walks_read_item", "api_users_read_item", "api_area_read_item"})
     * @Assert\NotBlank
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item", "api_users_read_item"})
     */
    private $duration;

    /**
     * @ORM\Column(name="difficulty", type="WalkDifficultyType")
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\WalkDifficultyType")  
     * @Assert\NotBlank
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item", "api_users_read_item"})
     */
    private $difficulty;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item"})
     * @Assert\Range(
     *      min = 0,
     *      max = 2000,
     *      notInRangeMessage = "Vous devez choisir une valeur comprise entre {{ min }}m et {{ max }}m",
     * )
     */
    private $elevation;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item"})
     * @Assert\PositiveOrZero
     */
    private $maxNbPersons;

    /**
     * @ORM\Column(type="text")
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item"})
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"api_walks_read", "api_walks_read_item", "api_users_read_item", "api_area_read_item"})
     * @Assert\PositiveOrZero
     */
    private $kilometre;

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
     * @Groups({"api_walks_read", "api_walks_read_item", "api_users_read_item"})
     * @Assert\NotBlank
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="walks", cascade={"persist"})
     * @Assert\NotBlank
     * @Groups({"api_walks_read", "api_walks_read_item", "api_area_read_item", "api_users_read_item"})
     */
    private $creator;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="walk", cascade={"remove","persist"})
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $participants;

     /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups("api_walks_read_item")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="walks")
     * @ORM\JoinTable(name="walk_tag")
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $tags;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

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

    public function setDate(?\DateTimeInterface $date): self
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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->setCreatedAt(new \DateTime());
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
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt(new \DateTime());

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

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("requestStatus", "1"));
        return $this->participants->matching($criteria);
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setWalk($this);
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setParticipant()
    {
        $participant = new Participant();
        $participant->setUser($this->creator);
        $participant->setWalk($this);
        $this->addParticipant($participant);
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getWalk() === $this) {
                $participant->setWalk(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setStatusValue()
    {
        $this->setStatus(1);
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getKilometre(): ?int
    {
        return $this->kilometre;
    }

    public function setKilometre(?int $kilometre): self
    {
        $this->kilometre = $kilometre;

        return $this;
    }
}
