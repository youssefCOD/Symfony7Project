<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\AddCategoriesFromType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/categories', name: 'app_admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addkeyword(
        Request $request ,
        SluggerInterface $slugger ,
        EntityManagerInterface $em
        ): Response
    {
        $category = new Category();
        
        $categoryForm = $this->createForm(AddCategoriesFromType::class, $category);

        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            // generate the slug here
            $slug =strtolower($slugger->slug($category->getName()));
            
            $category->setSlug($slug);

            $em->persist($category);
            $em->flush();

            $this->addFlash('succes ', 'categoy created');
            return $this->redirectToRoute('app_admin_categories_index');
        }
        return $this->render('admin/categories/add.html.twig', [
            'categoryForm' => $categoryForm->createView(),
        ]);
    }
}
