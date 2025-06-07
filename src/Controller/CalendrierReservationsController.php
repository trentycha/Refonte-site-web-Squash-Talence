<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CalendrierRepository;
use DateTimeImmutable;
use DateInterval;

final class CalendrierReservationsController extends AbstractController
{
    #[Route('/calendrier/reservations', name: 'app_calendrier_reservations')]
    public function index(Request $request, CalendrierRepository $repository): Response
    {
        $dayParam = $request->query->get('day');
        $startOfDay = $dayParam ? new DateTimeImmutable($dayParam) : new DateTimeImmutable('today');
        $endOfDay = $startOfDay->setTime(23, 59, 59);

        $allCalendriers = $repository->findAll();
        $reservationsByDatetime = [];

        foreach ($allCalendriers as $c) {
            $date = $c->getDate();
            $hour = $c->getHour();
            $terrain = $c->getTerrain();
            $user = $c->getUser();

            if (!$date || !$hour || !$terrain || !$user) {
                continue;
            }

            $datetime = (clone $date)->setTime((int)$hour->format('H'), (int)$hour->format('i'));
            if ($datetime >= $startOfDay && $datetime <= $endOfDay) {
                $key = $c->getTerrain() . '_' . $hour->format('H');
                $reservationsByDatetime[$key] = $c;
            }
        }

        $previousDay = $startOfDay->sub(new DateInterval('P1D'));
        $nextDay = $startOfDay->add(new DateInterval('P1D'));

        return $this->render('calendrier_reservations/index.html.twig', [
            'reservationsByDatetime' => $reservationsByDatetime,
            'startOfDay' => $startOfDay,
            'endOfDay' => $endOfDay,
            'previousDay' => $previousDay,
            'nextDay' => $nextDay,
        ]);
    }
}
