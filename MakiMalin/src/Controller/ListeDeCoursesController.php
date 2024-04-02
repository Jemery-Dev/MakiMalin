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

    #[Route('id=/{id}', name: 'app_liste_de_courses_show', methods: ['GET'])]
    public function show(ListeDeCourses $listeDeCourse, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        // Tableau associatif pour stocker le nombre d'articles par magasin
        $articlesParMagasin = [];
        // Tableau associatif pour stocker le prix total par magasin
        $prixTotalParMagasin = [];
        $totalPrices = 0;
        $totalPriceCount = 0;
        $maxPrice = null;
        $minPrice = null;
        $maxPriceArticle = null;
        $minPriceArticle = null;

        foreach ($listeDeCourse->getCourses() as $course) {
            $totalPrices += ($course->getQuantite() * $course->getArticle()->getPrix());
            $totalPriceCount += $course->getQuantite();

            if ($maxPrice === null || $course->getArticle()->getPrix() > $maxPrice) {
                $maxPrice = $course->getArticle()->getPrix();
                $maxPriceArticle = $course->getArticle()->getNom();
            }

            if ($minPrice === null || $course->getArticle()->getPrix() < $minPrice) {
                $minPrice = $course->getArticle()->getPrix();
                $minPriceArticle = $course->getArticle()->getNom();
            }
            $article = $course->getArticle();
            $magasin = $article->getMagasin();

            // Calcul du nombre d'articles par magasin
            $articlesParMagasin[$magasin->getNom()] = isset($articlesParMagasin[$magasin->getNom()]) ? $articlesParMagasin[$magasin->getNom()] + 1 : 1;

            // Calcul du prix total par magasin
            $prixArticle = $course->getQuantite() * $article->getPrix();
            $prixTotalParMagasin[$magasin->getNom()] = isset($prixTotalParMagasin[$magasin->getNom()]) ? $prixTotalParMagasin[$magasin->getNom()] + $prixArticle : $prixArticle;
        }

        $averagePrice = number_format((($totalPriceCount > 0) ? $totalPrices / $totalPriceCount : 0), 2);
        return $this->render('liste_de_courses/show.html.twig', [
            'liste_de_courses' => $listeDeCourse,
            'articles' => $articles,
            'totalPrices' => $totalPrices,
            'totalPriceCount' => $totalPriceCount,
            'averagePrice' => $averagePrice,
            'maxPrice' => $maxPrice,
            'maxPriceArticle' => $maxPriceArticle,
            'minPrice' => $minPrice,
            'minPriceArticle' => $minPriceArticle,
            'articlesParMagasin' => $articlesParMagasin,
            'prixTotalParMagasin' => $prixTotalParMagasin,
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

        $existingCourse = $entityManager->getRepository(Course::class)->findOneBy([
            'article' => $article,
            'liste_id' => $listeDeCourses,
        ]);

        $quantity = (int) $request->request->get('quantity', 1);

        if ($existingCourse) {
            $existingCourse->setQuantite($existingCourse->getQuantite() + $quantity);
        } else {
            $course = new Course();
            $course->setArticle($article);
            $course->setQuantite($quantity);
            $course->setListeId($listeDeCourses);
            $course->setAchete(false);
            $entityManager->persist($course);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_liste_de_courses_show', ['id' => $listeDeCourses->getId()]);
    }



}
