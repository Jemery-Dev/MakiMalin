<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Utilisateur;
use App\Entity\ListeCollaborative;
use App\Entity\ListeDeCourses;
use App\Form\ListeDeCoursesType;
use App\Repository\ListeDeCoursesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use App\Entity\Course;
use App\Repository\ArticleRepository;

#[Route('/liste')]


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
    public function show(ListeDeCourses $listeDeCourse, UtilisateurRepository $utilisateurRepository,ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $articles = $articleRepository->findAll();
        $users = $utilisateurRepository->findAll();
    
        $listeCollaborative = $listeDeCourse->getListeCollaborative();
        if (!$listeCollaborative) {
            $listeCollaborative = new ListeCollaborative();
            $listeCollaborative->setListeDeCourses($listeDeCourse);
            $entityManager->persist($listeCollaborative);
            $entityManager->flush();
        }

        $form = $this->createFormBuilder()
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'username',
                'label' => 'Ajouter un utilisateur :',
                'placeholder' => 'Sélectionnez un utilisateur',
            ])
            ->add('ajouter', SubmitType::class, ['label' => 'Ajouter'])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $utilisateur = $data['utilisateur'];
            $listeCollaborative->addUtilisateur($utilisateur);
            $entityManager->flush();
    
            $this->addFlash('success', 'Utilisateur ajouté avec succès à la liste collaborative.');
        }
    
        return $this->render('liste_de_courses/show.html.twig', [
            'liste_de_courses' => $listeDeCourse,
            'articles' => $articles,
            'liste_collaborative' => $listeCollaborative,
            'form' => $form->createView(),
            'users' => $users,
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

        if ($this->isCsrfTokenValid('delete' . $listeDeCourse->getId(), $request->request->get('_token'))) {
                $listeCollaborative = $listeDeCourse->getListeCollaborative();
                $entityManager->remove($listeCollaborative);

                // Supprimer la liste_de_courses
                $entityManager->remove($listeDeCourse);
                $entityManager->flush();
        }
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-article/{articleId}', name: 'app_liste_de_courses_add_article', methods: ['POST'])]
    public function addArticleToList(ListeDeCourses $listeDeCourses, int $articleId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($articleId);

        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        $quantity = $request->request->get('quantity', 1);

        $course = new Course();
        $course->setArticle($article);
        $course->setQuantite($quantity);
        $course->setListeId($listeDeCourses);
        $course->setAchete(false);

        $entityManager->persist($course);
        $entityManager->flush();

        return $this->redirectToRoute('app_liste_de_courses_show', ['id' => $listeDeCourses->getId()]);
    }
}
