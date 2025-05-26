<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Form\NewArticleType;
use App\Repository\ArticleRepository; 

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function show(int $id, ArticleRepository $repository): Response
    {
        $item = $repository->find($id);
        return $this->render('article/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/article/{id}/edit', name: 'article_edit')]
    public function edit(int $id, ArticleRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $repository->find($id);
        $formA = $this->createForm(NewArticleType::class, $article);
        $formA->handleRequest($request);
        if ($formA->isSubmitted() && $formA->isValid()) { 
            $entityManager->flush();
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'formA' => $formA->createView(),
        ]);

    }

    #[Route('/article/{id}/delete', name: 'article_delete')]
    public function delete(int $id, ArticleRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = $repository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
    
        return $this->redirectToRoute('article');

    }

    #[Route('/article/new', name: 'article_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $formA = $this->createForm(NewArticleType::class, $article);
        $formA->handleRequest($request);
        if ($formA->isSubmitted() && $formA->isValid()) { 
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        return $this->render('article/new.html.twig', [
            'article' => $article,
            'formA' => $formA->createView(),
        ]);

    }
}

