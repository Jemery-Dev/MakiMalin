<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\CategorieArticle;
use App\Entity\Utilisateur;
use App\Entity\ListeDeCourses;
use App\Entity\ListeCollaborative;
use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //$user = $this->getUser();
        //if ($user && $user->getUsername() === 'minH') {
            $routeBuilder = $this->container->get(AdminUrlGenerator::class);
            $routeBuilder->setController(ArticleCrudController::class);
            $url = $routeBuilder->generateUrl();
            return $this->redirect($url);
        //} else {
            //throw $this->createAccessDeniedException('Access Denied');
        //}

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MakiMalin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Retourner au site', 'fas fa-home', 'app_home');
        yield MenuItem::linkToCrud('Articles', 'fas fa-cart-shopping', Article::class);
        yield MenuItem::linkToCrud('Catégories Articles', 'fas fa-filter', CategorieArticle::class);
        yield MenuItem::linkToCrud('Liste de Collaboratives', 'fas fa-user-group', ListeCollaborative::class);
        yield MenuItem::linkToCrud('Liste de Courses', 'fas fa-list', ListeDeCourses::class);
        yield MenuItem::linkToCrud('Courses', 'fas fa-filter', Course::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-circle-user', Utilisateur::class);
    }
}
