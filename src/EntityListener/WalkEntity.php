<?php

namespace App\EntityListener;

use App\Entity\Walk;
use App\Entity\Participant;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WalkEntity
{
    private $tokenStorage;

    /**
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * 
     * @param Walk $walk
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function prePersist(Walk $walk, LifecycleEventArgs $event)
    {
        //Set Creator
        $user = $this->tokenStorage->getToken()->getUser();
        $walk->setCreator($user);

        //Set creator at participant
        $participant = new Participant();
        $participant->setUser($user);
        $participant->setWalk($walk);
        $walk->addParticipant($participant);

        //Set status
        $walk->setStatus(1);

        // Set Created at
        $walk->setCreatedAt(new \DateTime());
    }

    /**
     *
     * @param Walk $walk
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function preUpdate(Walk $walk, LifecycleEventArgs $event)
    {
        $walk->setUpdatedAt(new \DateTime());
    }
}