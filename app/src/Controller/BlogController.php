<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Bic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/blog/edit/{id}', name: 'edit_blog')]
    // VERIFIE SI LE USER EST CONNECTER
    #[IsGranted('ROLE_USER')]
    public function edit(Blog $blog): Response
    {
        // Utiliser le voter et on verifier une règle, on met ce que l'ont veut et là c'est BLOG_EDIT (il faut qu'il se retrouve dans le voter)
        // Le support du voter continu suivant si c'est true ou false
        // Le $blog correspond au $subject dans le voter pour rentrer dans la condition du support
        $this->denyAccessUnlessGranted('BLOG_EDIT', $blog);

        $user = $this->getUser();

        if ($blog->getAuthor() === $user) {
            dump('edition ok');
        } else {
            dump('edit koooo');
        }

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/test', name: 'test')]
    public function test(EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $user = $userRepo->find(4);

        $blog = new Blog();
        $blog->setContent('123');

        $blog->setAuthor($user);

        $em->persist($blog);
        $em->flush();


        return $this->redirectToRoute('home');
    }
}
