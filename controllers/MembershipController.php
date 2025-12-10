<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Models\Product;

class MembershipController extends Controller
{
    public function index(): void
    {
        $productModel = new Product($this->db());
        $membership = $productModel->findByName('Hacerse Socio');

        $this->render('membership/index', [
            'pageTitle' => 'Hazte socio VIP | DrPitbike',
            'membershipProduct' => $membership,
        ]);
    }
}
