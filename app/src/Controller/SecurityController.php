<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Forms;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Création de l'user
        $user = new User();

        // création du form basé sur une entity User
        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        // verification de le submission du form
        if($userForm->isSubmitted() && $userForm->isValid()) {

            // Hash le mot de passe
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('security/inscription.html.twig', [
            'form' => $userForm->createView()
        ]);
    }

    #[Route('/connexion', name: 'connexion')]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {

        // Stock les erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        // stock l'user qui va se connecter
        $username = $authenticationUtils->getLastUsername();

        // check errors
        // if($error) {
        //     dd($error->getMessageKey());
        // }

        return $this->render('security/connexion.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }

    // route logout
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}
