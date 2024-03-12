<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function show(\Throwable $exception): Response
    {
        // Obtenez le code de l'exception s'il est disponible
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        // Gérer l'exception selon vos besoins
        // Par exemple, vous pouvez ajouter un message d'erreur personnalisé ou d'autres variables à passer au template

        return $this->render('error/error404.html.twig', [
            'statusCode' => $statusCode,
            'exception' => $exception,
        ]);
    }
}

?>