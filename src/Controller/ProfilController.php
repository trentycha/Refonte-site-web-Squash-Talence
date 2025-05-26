<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;  
use Symfony\Component\HttpFoundation\Request;

final class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'profi_show')]
    public function show(int $id, UserRepository $repository): Response
    {

        $user = $repository->find($id);

        return $this->render('profil_show/index.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/profil/edit/{id}', name: 'profil/edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {

        $user = $repository->find($id);
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profil_show', ['id' => $user->getId()]);
        }

        return $this->render('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
