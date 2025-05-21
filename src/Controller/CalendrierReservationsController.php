<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalendrierReservationsController extends AbstractController
{
    #[Route('/calendrier/reservations', name: 'app_calendrier_reservations')]
    public function index(): Response
    {
        return $this->render('calendrier_reservations/index.html.twig', [
            'controller_name' => 'CalendrierReservationsController',
        ]);
    }
}
