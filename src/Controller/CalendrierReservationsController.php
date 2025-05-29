<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ReservationRepository;

final class CalendrierReservationsController extends AbstractController
{
    #[Route('/calendrier/reservations', name: 'app_calendrier_reservations')]
    public function index(ReservationRepository $repository): Response
    {
        $reservation = $repository->findAll();

        return $this->render('calendrier_reservations/index.html.twig', [
            'reservation' => $reservation,
            'controller_name' => 'CalendrierReservationsController',
        ]);
    }
}
