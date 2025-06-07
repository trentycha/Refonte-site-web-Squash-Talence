<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{

    #[Route('/register', name: 'register')]
public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
{
    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        // Récupère le mot de passe du champ "plainPassword"
        $plainPassword = $form->get('plainPassword')->getData();

        $user->setPassword(
            $passwordHasher->hashPassword($user, $plainPassword)
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }

    return $this->render('register/index.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
        'controller_name' => 'RegisterController',
    ]);
}

    
}
