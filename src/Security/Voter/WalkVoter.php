<?php

namespace App\Security\Voter;

use App\Entity\Walk;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class WalkVoter extends Voter
{
    const UPDATE = "update";
    const DELETE = "delete";
    const CREATE = "create";

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::UPDATE, self::DELETE, self::CREATE])
            && $subject instanceof \App\Entity\Walk;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // you know $subject is a walk or Answer object, thanks to `supports()`
        /** @var Walk $walk */
        $walk = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::UPDATE:
                return $user === $walk->getCreator();
                break;
            case self::DELETE:
                return $user === $walk->getCreator();
                break;
            case self::CREATE:
                return $user === $walk->getCreator();
                break;
        }

        return false;
    }
}
