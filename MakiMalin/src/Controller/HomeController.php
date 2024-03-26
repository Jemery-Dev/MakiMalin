<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ListeDeCourses;
use App\Form\ListeDeCoursesType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ListeDeCoursesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListeDeCoursesRepository $listeDeCoursesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $listeDeCourses = $listeDeCoursesRepository->findAll();
        $listeDeCoursesForm = new ListeDeCourses();

        // Set the user ID directly in the entity
        $user = $this->getUser();
        $listeDeCoursesForm->setUtilisateur($user); // Assuming $utilisateur is the user property in ListeDeCourses entity

        $form = $this->createForm(ListeDeCoursesType::class, $listeDeCoursesForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listeDeCoursesForm);
            $entityManager->flush();

            $this->addFlash('success', 'Liste de courses ajoutée avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'liste_de_courses' => $listeDeCourses,
            'form' => $form->createView(),
        ]);
    }
}
