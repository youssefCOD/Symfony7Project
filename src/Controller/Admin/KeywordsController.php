<?php

namespace App\Controller\Admin;

use App\Entity\Keywords;
use App\Form\AddKeywordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/keywords', name: 'app_admin_keywords_')]
class KeywordsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/keywords/index.html.twig', [
            'controller_name' => 'KeywordsController',
        ]);
    }
    
    #[Route('/add', name: 'add')]
    public function addkeyword(
        Request $request ,
        SluggerInterface $slugger ,
        EntityManagerInterface $em
        ): Response
    {
        $keywords = new Keywords();
        
        $keywordForm = $this->createForm(AddKeywordFormType::class, $keywords);

        $keywordForm->handleRequest($request);

        if($keywordForm->isSubmitted() && $keywordForm->isValid()) {
            // generate the slug here
            $slug =strtolower($slugger->slug($keywords->getName()));
            
            $keywords->setSlug($slug);

            $em->persist($keywords);
            $em->flush();

            $this->addFlash('succes ', 'keyword created');
            return $this->redirectToRoute('app_admin_keywords_index');
        }
        return $this->render('admin/keywords/add.html.twig', [
            'keywordForm' => $keywordForm->createView(),
        ]);
    }
}
