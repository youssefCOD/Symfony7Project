<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(PostsRepository $postsRepository, UsersRepository $usersRepository): Response
    {
        //here we are selecting the latest post avialable 
        $lastPost = $postsRepository->findOneBy([], ['id' => 'desc']);
        //here we are selecting latest 8 posts
        $posts = $postsRepository->findBy([], ['id' => 'desc'], 8);

        $users = $usersRepository->getUsersByPosts(4);//getting just the 4 latest users
        return $this->render('homepage/index.html.twig', compact('lastPost','posts','users'));
    }
}
