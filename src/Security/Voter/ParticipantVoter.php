<?php

namespace App\Security\Voter;

use App\Entity\Participant;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ParticipantVoter extends Voter
{
    CONST UPDATE = "update";
    
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::UPDATE])
            && $subject instanceof \App\Entity\Participant;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Participant $participant */
        $participant = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::UPDATE:
                return $user === $participant->getUser();
                break;
        }

        return false;
    }
}
