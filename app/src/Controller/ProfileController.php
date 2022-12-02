<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Node\DumpNode;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Security $security): Response
    {

        // Autre méthode pour le contrôle d'accès : depuis le controle ...
        // $this->denyAccessUnlessGranted('ROLE_USER');
        // $this->isGranted('IS_AUTHENTICATED_FULLY');

        // récupérer les info de l'user via la méthod normal
        // $user = $this->getUser();

        // récupérer les info de l'user via la méthod Sécurity
        $user = $security->getUser();
        // dd($user);



        return $this->render('profile/index.html.twig', [
            // 'user' => $user
        ]);
    }
}
