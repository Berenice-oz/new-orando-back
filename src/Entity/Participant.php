<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipantRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $requestStatus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participants")
     * 
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Walk::class, inversedBy="participants")
     * 
     * @Groups ("api_users_read_item")
     */
    private $walk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestStatus(): ?string
    {
        return $this->requestStatus;
    }

    public function setRequestStatus(string $requestStatus): self
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
