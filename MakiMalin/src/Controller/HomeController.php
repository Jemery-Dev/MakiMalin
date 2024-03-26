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

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListeDeCoursesRepository $listeDeCoursesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $listeDeCourses = $listeDeCoursesRepository->findBy(['utilisateur' => $user]);
        $listeDeCoursesForm = new ListeDeCourses();

        $listeDeCoursesForm->setUtilisateur($user);

        $form = $this->createForm(ListeDeCoursesType::class, $listeDeCoursesForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listeDeCoursesForm);
            $entityManager->flush();
            $this->addFlash('success', 'Liste de courses ajoutée avec succès.');
            return $this->redirectToRoute('app_liste_de_courses_show', ['id' => $listeDeCoursesForm->getId()]);
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'liste_de_courses' => $listeDeCourses,
            'form' => $form->createView(),
        ]);
    }
}
