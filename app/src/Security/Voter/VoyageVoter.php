<?php

namespace App\Security\Voter;

use App\Entity\Voyage;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class VoyageVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Voyage) {
            return true;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return true;
        }

        /** @var Voyage $voyage */
        $voyage = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canViewAgence($voyage, $user);
            case self::EDIT:
                return $this->canEditAgence($voyage, $user);
            case self::DELETE:
                return $this->canEditAgence($voyage, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canViewAgence(Voyage $voyage, User $user): bool
    {
        return ($user === $voyage->getUser() && $user->getRoles()[0] === 'ROLE_AGENCE') || $user->getRoles()[0] !== 'ROLE_AGENCE';
    }

    private function canEditAgence(Voyage $voyage, User $user): bool
    {
        return $user === $voyage->getUser();
    }

    private function canDeleteAgence(Voyage $voyage, User $user): bool
    {
        return $user === $voyage->getUser();
    }
}