<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {

        // Autre méthode pour le contrôle d'accès : depuis le controle ...
        // $this->denyAccessUnlessGranted('ROLE_USER');
        $this->isGranted('IS_AUTHENTICATED_FULLY');


        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
