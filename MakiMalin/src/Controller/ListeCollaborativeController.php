<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\ArticleRepository;
use App\Entity\ListeCollaborative;
use App\Form\ListeCollaborativeType;
use App\Repository\ListeCollaborativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/liste/collaborative')]
class ListeCollaborativeController extends AbstractController
{
    #[Route('/', name: 'app_liste_collaborative_index', methods: ['GET'])]
    public function index(ListeCollaborativeRepository $listeCollaborativeRepository): Response
    {
        return $this->render('liste_collaborative/index.html.twig', [
            'liste_collaboratives' => $listeCollaborativeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_liste_collaborative_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listeCollaborative = new ListeCollaborative();
        $form = $this->createForm(ListeCollaborativeType::class, $listeCollaborative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listeCollaborative);
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_collaborative_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_collaborative/new.html.twig', [
            'liste_collaborative' => $listeCollaborative,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_liste_collaborative_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListeCollaborative $listeCollaborative, EntityManagerInterface $entityManager): Response
    {
        dump("douze");
        $form = $this->createForm(ListeCollaborativeType::class, $listeCollaborative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_liste_collaborative_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liste_collaborative/edit.html.twig', [
            'liste_collaborative' => $listeCollaborative,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_liste_collaborative_delete', methods: ['POST'])]
    public function delete(Request $request, ListeCollaborative $listeCollaborative, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $listeCollaborative->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listeCollaborative);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liste_collaborative_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_liste_collaborative_show', methods: ['GET'])]#[Route('/{id}', name: 'app_liste_collaborative_show', methods: ['GET'])]
    public function show(ListeCollaborative $listeCollaborative, ArticleRepository $articleRepository, Security $security): Response
    {
        $currentUser = $security->getUser();
        $utilisateurs = $listeCollaborative->getUtilisateurs();
        $isUserAuthorized = false;
    
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur->getId() === $currentUser->getId()) {
                $isUserAuthorized = true;
                break;
            }
        }
        if (!$isUserAuthorized) {
            throw $this->createNotFoundException('Vous n\'êtes pas autorisé à accéder à cette liste collaborative.');
        }
    
        $articles = $articleRepository->findAll();
        $liste_de_courses = $listeCollaborative->getListeDeCourses();
    
        return $this->render('liste_collaborative/show.html.twig', [
            'liste_de_courses' => $liste_de_courses,
            'articles' => $articles,
        ]);
    }
    
}
