<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouterService extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function getRedirectRouteForUser(User $user): string
    {
        // 1) ADMIN
        if ($user->isAdmin()) {
            return $this->urlGenerator->generate('admin_dashboard');
        }
        
        // Sécurité : incohérence métier, un coach doit toujours être membre
        if ($user->isCoach() && !$user->isMember()) {
            // TODO: logger/alerter — situation normalement impossible
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
