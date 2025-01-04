<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Posts;
use App\Form\CommentType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path:'/posts', name:'app_posts_')]
class PostsController extends AbstractController
{
    #[Route(path:'/details/{slug}', name:'details')]
    public function details($slug, PostsRepository $postsRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = $postsRepository->findOneBy(['slug'=> $slug]);

        // Si le post n'existe pas
        if(!$post){
            throw $this->createNotFoundException('Cet article n\'existe pas');
        }


        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUsers($this->getUser());
            $comment->setPosts($post);
            
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_posts_details', ['slug' => $post->getSlug()]);
        }


        // Ici l'article existe, on l'envoie à la vue
        return $this->render('posts/details.html.twig', [
            'post' => $post,
            'comment_form' => $form->createView(),
        ]);
    }
}