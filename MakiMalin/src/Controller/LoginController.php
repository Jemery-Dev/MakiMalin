<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;


use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

  class LoginController extends AbstractController
  {
      #[Route('/login', name: 'app_login')]
      public function index(AuthenticationUtils $authenticationUtils, UtilisateurRepository $UtilisateurRepository): Response
      {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
 
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
 
        if($lastUsername != ""){
            $user = $UtilisateurRepository->findOneBy(['username'=>'douze']);
        }else{
            $user = null;
        }

          return $this->render('login/index.html.twig', [
              'last_username' => $lastUsername,
              'error'         => $error,
              'user' => $user,
          ]);
      }
  }