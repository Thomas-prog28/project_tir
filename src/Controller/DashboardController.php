<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response {
        return new Response("Accueil");
    }

    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function adminDashboard(): Response {
        return new Response("Dashboard admin");
    }

    #[Route('/member/dashboard', name: 'member_dashboard')]
    public function memberDashboard(): Response {
        return new Response("Dashboard membre");
    }
}
