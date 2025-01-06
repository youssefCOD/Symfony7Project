<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function editProfile(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        /** @var Users $user */
        $user = $this->getUser();
        
        // Create a form for the user profile
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string|null $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            
            if ($plainPassword) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword($user, $plainPassword)
                );
            }

            // Persist changes to the database
            $entityManager->flush();
            
            $this->addFlash('success', 'Your profile has been updated successfully!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user_profile/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}