<?php

namespace App\Security; 

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MemberVoter extends Voter
{
    public const MEMBER_ACCESS = 'MEMBER_ACCESS';
    public const COACH_ACCESS = 'COACH_ACCESS';
    public const CA_MEMBER_ACCESS = 'CA_MEMBER_ACCESS';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [
            self::MEMBER_ACCESS, 
            self::COACH_ACCESS,
            self::CA_MEMBER_ACCESS,
        ], true);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        //Utilisateur non connecté -> refusé
        if (!$user instanceof User) {
            return false;
        }

        return match($attribute) {
            self::MEMBER_ACCESS => $user->isMember(),
            self::COACH_ACCESS => $user->isCoach(),
            self::CA_MEMBER_ACCESS => $user->isCaMember(),
            default => false,
        };
    }
}