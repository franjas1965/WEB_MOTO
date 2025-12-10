<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Event;

class ScheduleController extends Controller
{
    public function index(): void
    {
        $eventModel = new Event($this->db());
        $selectedCircuit = trim($_GET['circuito'] ?? '');

        $this->render('schedule/index', [
            'pageTitle' => 'Calendario de Rodadas | DrPitbike',
            'circuitos' => $eventModel->circuits(),
            'selectedCircuit' => $selectedCircuit,
            'events' => $eventModel->upcomingByCircuit($selectedCircuit !== '' ? $selectedCircuit : null),
        ]);
    }
}
