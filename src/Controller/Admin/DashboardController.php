<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Conference;
use App\Entity\Comment;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Guestbook');
    }

    public function configureMenuItems(): iterable
	{
		return[
			MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
			MenuItem::section('Conferences'),
        	MenuItem::linkToCrud('Conference', 'icon class', Conference::class),
        	MenuItem::linkToCrud('Comments', 'icon class', Comment::class)
		];
	}
}
