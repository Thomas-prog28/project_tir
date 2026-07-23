<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Security\MemberVoter;



class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response {
        return new Response("Accueil");
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminDashboard(): Response {
        return new Response("Dashboard admin");
    }

    #[Route('/member/dashboard', name: 'member_dashboard')]
    #[IsGranted(MemberVoter::MEMBER_ACCESS)]
    public function memberDashboard(): Response {
        return new Response("Dashboard membre");
    }
}
