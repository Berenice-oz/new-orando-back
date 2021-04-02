<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipantRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 * @UniqueEntity(fields={"user", "walk"})
 * @ORM\HasLifecycleCallbacks()
 */
class Participant
{
    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Range(
     * min = 0,
     * max = 2,
     * notInRangeMessage = "La valeur doit être comprise entre {{ min }} et {{ max }}"
     * )
     */
    private $requestStatus;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participants")
     * @Assert\NotBlank
     * @Groups({"api_walks_read", "api_walks_read_item"})
     */
    private $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Walk::class, inversedBy="participants")
     * @Assert\NotBlank
     * @Groups ("api_users_read_item")
     */
    private $walk;

    public function __construct()
    {
        $this->requestStatus = 1;
    }

    public function getRequestStatus(): ?int
    {
        return $this->requestStatus;
    }

    public function setRequestStatus(int $requestStatus): self
    {
        $this->requestStatus = $requestStatus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getWalk(): ?Walk
    {
        return $this->walk;
    }

    public function setWalk(?Walk $walk): self
    {
        $this->walk = $walk;

        return $this;
    }
}
