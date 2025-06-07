<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Calendrier;
use App\Repository\CalendrierRepository;

final class ResaCalendrierController extends AbstractController
{
    #[Route('/resaCalendrier', name: 'resa_calendrier')]
    public function new(Request $request, EntityManagerInterface $entityManager, CalendrierRepository $repository): Response
    {
        $dateParam = $request->query->get('date');
        $terrainParam = $request->query->get('terrain');

        if (!$dateParam || !$terrainParam) {
            return $this->redirectToRoute('app_calendrier_reservations');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour réserver.');
        }

        $dateTime = new \DateTimeImmutable($dateParam);

        $existingReservation = $repository->findOneBy([
            'date' => $dateTime,
            'hour' => $dateTime,
            'terrain' => (int) $terrainParam,
        ]);

        if ($existingReservation) {
            $this->addFlash('error', 'Ce créneau est déjà réservé.');
            return $this->redirectToRoute('app_calendrier_reservations', ['day' => $dateTime->format('Y-m-d')]);
        }

        $calendrier = new Calendrier();
        $calendrier->setDate($dateTime);
        $calendrier->setHour($dateTime);
        $calendrier->setTerrain((int) $terrainParam);
        $calendrier->setUser($user);

        $entityManager->persist($calendrier);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été enregistrée !');

        return $this->redirectToRoute('app_profil');
    }

    #[Route('/resaCalendrier/{id}', name: 'resa_calendrier_show', requirements: ['id' => '\d+'])]
    public function show(string $id, CalendrierRepository $repository): Response
    {
        $id = (int) $id;
        $calendrier = $repository->find($id);

        if (!$calendrier) {
            throw $this->createNotFoundException('Réservation introuvable.');
        }

        return $this->render('resa_calendrier/show.html.twig', [
            'calendrier' => $calendrier,
        ]);
    }

    #[Route('/resaCalendrier/edit/{id}', name: 'resa_calendrier_edit', requirements: ['id' => '\d+'])]
    public function edit(string $id, Request $request, CalendrierRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $id = (int) $id;
        $calendrier = $repository->find($id);

        if (!$calendrier) {
            throw $this->createNotFoundException('Réservation introuvable.');
        }

        $form = $this->createForm(CalendarType::class, $calendrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('resa_calendrier_show', ['id' => $calendrier->getId()]);
        }

        return $this->render('resa_calendrier/edit.html.twig', [
            'calendrier' => $calendrier,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/resaCalendrier/delete/{id}', name: 'resa_calendrier_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function remove(string $id, Request $request, CalendrierRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $id = (int) $id;
        $calendrier = $repository->find($id);

        if (!$calendrier) {
            throw $this->createNotFoundException('Réservation introuvable.');
        }

        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $entityManager->remove($calendrier);
            $entityManager->flush();
            $this->addFlash('success', 'Réservation supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression — token CSRF invalide.');
        }

        return $this->redirectToRoute('app_profil');
    }

    #[Route('/resaCalendrier/all', name: 'resa_calendrier_all')]
    public function index(CalendrierRepository $repository): Response
    {
        $calendrier = $repository->findAll();

        return $this->render('resa_calendrier/all.html.twig', [
            'calendrier' => $calendrier,
        ]);
    }
}
