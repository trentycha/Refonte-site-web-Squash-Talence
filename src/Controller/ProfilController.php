<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function redirectToProfile(): RedirectResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('profil_show', ['id' => $user->getId()]);
    }

    #[Route('/profil/{id}', name: 'profil_show')]
    public function show(User $user): Response
    {
        return $this->render('profil/show.html.twig', [
            'user' => $user,
        ]);
    }

            #[Route('/profil/edit/{id}', name: 'profil_edit')]
            public function edit(
                User $user,
                Request $request,
                EntityManagerInterface $entityManager,
                UserPasswordHasherInterface $passwordHasher
            ): Response {
                $form = $this->createForm(RegisterType::class, $user, ['include_password' => false]);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('profil_show', ['id' => $user->getId()]);
                }

                return $this->render('profil/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);
            }


}
