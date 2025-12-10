<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Booking;

class ProfileController extends Controller
{
    public function dashboard(): void
    {
        $user = $this->requireAuth('/login');
        $bookingModel = new Booking($this->db());

        $this->render('profile/dashboard', [
            'pageTitle' => 'Área de Cliente | DrPitbike',
            'currentUser' => $user,
            'bookings' => $bookingModel->findByUser((int) $user['id']),
        ]);
    }
}
