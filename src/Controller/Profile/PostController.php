<?php

namespace App\Controller\Profile;

use App\Entity\Comments;
use App\Entity\Posts;
use App\Form\AddPostFormType;
use App\Form\CommentType;
use App\Repository\UsersRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\PostsRepository;

#[Route('/profile/post', name: 'app_profile_post_')]
class PostController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PostsRepository $postsRepository): Response
    {
        $posts = $postsRepository->findBy([], ['id' => 'desc'], 8);

        return $this->render('profile\post\index.html.twig', compact('posts'));
    }
    #[Route('/add', name: 'add')]
    public function addPost(
        Request $request ,
        SluggerInterface $slluger,
        EntityManagerInterface $em ,
        UsersRepository $usersRepository ,
        PictureService $pictureService
    ): Response
    {
        $post = new Posts();

        $Form = $this->createForm(AddPostFormType::class, $post);

        //treating the form here
        $Form->handleRequest($request);

        if ($Form->isSubmitted() && $Form->isValid()) {
            $post->setSlug(strtolower(($slluger->slug($post->getTitle()))));

            $post->setUsers($this->getUser());

            //adding the image here:
            $featuredImage = $Form->get('featuredImage')->getData();
            $image = $pictureService->square($featuredImage,'posts',300);

            $post->setFeaturedImage($image);
            
            $em->persist($post);
            $em->flush();

            $this->addFlash('succes ', 'Post created');
            return $this->redirectToRoute('app_profile_post_index');
        }
        return $this->render('profile\post\add.html.twig', [
            'Form' => $Form
        ]);    
    }


    // routes for deleting and updating 
    #[Route('/update/{id}', name: 'update')]
    public function editPost(
        Request $request,
        Posts $post,
        EntityManagerInterface $em,
        PictureService $pictureService
    ): Response {
        $form = $this->createForm(AddPostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newImage = $form->get('featuredImage')->getData();
            if ($newImage) {
                $imageFilename = $pictureService->square($newImage, 'posts', 300);
                $post->setFeaturedImage($imageFilename);
            }
        
            $em->persist($post);
            $em->flush();
        
            $this->addFlash('success', 'Post updated successfully!');
            return $this->redirectToRoute('app_profile_post_index');
        }

        return $this->render('profile/post/edit.html.twig', [
            'Form' => $form->createView(),
            'post' => $post,
        ]);
    }


    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function deletePost(Posts $post, EntityManagerInterface $em): Response
    {
        // $this->denyAccessUnlessGranted('POST_DELETE', $post);

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post deleted successfully');
        return $this->redirectToRoute('app_profile_post_index');
    }

}

