<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Form\CalendarType;

final class ResaCalendrierController extends AbstractController
{
    #[Route('/resaCalendrier', name: 'resa_calendrier')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(CalendarType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('resa_calendrier_show', ['id' => $reservation->getId()]);
        }

        return $this->render('resa_calendrier/index.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView()
        ]);
    }

    #[Route('/resaCalendrier/{id}', name: 'resa_calendrier_show')]
    public function show(int $id, ReservationRepository $repository): Response
    {
        $reservation = $repository->find($id);

        return $this->render('resa_calendrier_show/index.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/resaCalendrier/edit/{id}', name: 'resa_calendrier_edit')]
    public function edit(int $id, Request $request, ReservationRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $reservation = $repository->find($id);
        $form = $this->createForm(CalendarType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();

            return $this->redirectToRoute('resa_calendrier_show', ['id' => $reservation->getId()]);
        }

        return $this->render('resa_calendrier_edit/index.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView()
        ]);
    }

    #[Route('/resaCalendrier/delete/{id}', name: 'resa_calendrier_delete')]
    public function remove(int $id, Request $request, ReservationRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $reservation = $repository->find($id);
        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('resa_calendrier');
    }

     #[Route('/resaCalendrier/all', name: 'resa_calendrier_all')]
    public function index(ReservationRepository $repository): Response
    {
        $reservation = $repository->findAll();

        return $this->render('resa_calendrier_all/index.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
