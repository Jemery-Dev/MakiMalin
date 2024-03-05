<?php

namespace App\Controller;

use App\Entity\ListeDeCourses;
use App\Form\ListeDeCoursesType;
use App\Repository\ListeDeCoursesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/liste/de/courses')]
class ListeDeCoursesController extends AbstractController
{
    #[Route('/', name: 'app_liste_de_courses_index', methods: ['GET'])]
    public function index(ListeDeCoursesRepository $listeDeCoursesRepository): Response
    {
        return $this->render('liste_de_courses/index.html.twig', [
            'liste_de_courses' => $listeDeCoursesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_liste_de_courses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listeDeCourse = new ListeDeCourses();
        $form = $this->createForm(ListeDeCoursesType::class, $listeDeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listeDeCourse);
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_de_courses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_de_courses/new.html.twig', [
            'liste_de_course' => $listeDeCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_de_courses_show', methods: ['GET'])]
    public function show(ListeDeCourses $listeDeCourse): Response
    {
        return $this->render('liste_de_courses/show.html.twig', [
            'liste_de_course' => $listeDeCourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liste_de_courses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListeDeCourses $listeDeCourse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeDeCoursesType::class, $listeDeCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_de_courses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_de_courses/edit.html.twig', [
            'liste_de_course' => $listeDeCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liste_de_courses_delete', methods: ['POST'])]
    public function delete(Request $request, ListeDeCourses $listeDeCourse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listeDeCourse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listeDeCourse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liste_de_courses_index', [], Response::HTTP_SEE_OTHER);
    }
}
