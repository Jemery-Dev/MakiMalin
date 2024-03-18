<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// src/Controller/HomeController.php

use App\Repository\ListeDeCoursesRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListeDeCoursesRepository $listeDeCoursesRepository): Response
    {
        $listeDeCourses = $listeDeCoursesRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'liste_de_courses' => $listeDeCourses,
        ]);
    }
}

