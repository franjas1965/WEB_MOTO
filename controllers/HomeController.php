<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Event;

class HomeController extends Controller
{
    public function index(): void
    {
        $eventModel = new Event($this->db());

        $this->render('home/index', [
            'pageTitle' => 'DrPitbike | Vive la emoción de la velocidad',
            'events' => $eventModel->upcoming(6),
        ]);
    }
}
