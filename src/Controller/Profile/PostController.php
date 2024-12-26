<?php

namespace App\Controller\Profile;

use App\Entity\Posts;
use App\Form\AddPostFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profile/post', name: 'app_profile_post_')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile\post\index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/add', name: 'add')]
    public function addPost(
        Request $request ,
        SluggerInterface $slluger,
        EntityManagerInterface $em ,
        UsersRepository $usersRepository
    ): Response
    {
        $post = new Posts();

        $Form = $this->createForm(AddPostFormType::class, $post);

        //treating the form here
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()) {
            $post->setSlug(strtolower(($slluger->slug($post->getTitle()))));

            $post->setUsers($usersRepository->find(4));

            $post->setFeaturedImage('deafualt.webp');

            $em->persist($post);
            $em->flush();

            $this->addFlash('succes ', 'Post created');
            return $this->redirectToRoute('app_profile_post_index');
        }
        return $this->render('profile\post\add.html.twig', [
            'Form' => $Form
        ]);    
    }
}
