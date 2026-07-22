<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouterService
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function getRedirectRouteForUser(User $user): string
    {
        // 1) ADMIN
        if ($user->isAdmin()) {
            return $this->urlGenerator->generate('admin_dashboard');
        }

        // 2) USER sans statut
        if (!$user->isMember() && !$user->isCoach() && !$user->isCaMember()) {
            return $this->urlGenerator->generate('app_home');
        }

        // 3) USER membre (membre seul OU membre + coach)
        if ($user->isMember()) {
            return $this->urlGenerator->generate('member_dashboard');
        }

        // 4) USER ca_member uniquement
        if ($user->isCaMember()) {
            return $this->urlGenerator->generate('app_home');
        }

        // Sécurité : fallback
        return $this->urlGenerator->generate('app_home');
    }
}
