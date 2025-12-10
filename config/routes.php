<?php

declare(strict_types=1);

use Controllers\AuthController;
use Controllers\CartController;
use Controllers\HomeController;
use Controllers\MembershipController;
use Controllers\ProfileController;
use Controllers\ScheduleController;

return [
    'GET' => [
        '/' => ['controller' => HomeController::class, 'action' => 'index'],
        '/calendario' => ['controller' => ScheduleController::class, 'action' => 'index'],
        '/area-cliente' => ['controller' => ProfileController::class, 'action' => 'dashboard'],
        '/membresia' => ['controller' => MembershipController::class, 'action' => 'index'],
        '/login' => ['controller' => AuthController::class, 'action' => 'showLoginForm'],
        '/registro' => ['controller' => AuthController::class, 'action' => 'showRegisterForm'],
        '/carrito' => ['controller' => CartController::class, 'action' => 'index'],
    ],
    'POST' => [
        '/login' => ['controller' => AuthController::class, 'action' => 'login'],
        '/registro' => ['controller' => AuthController::class, 'action' => 'register'],
        '/logout' => ['controller' => AuthController::class, 'action' => 'logout'],
        '/carrito/agregar' => ['controller' => CartController::class, 'action' => 'add'],
        '/carrito/eliminar' => ['controller' => CartController::class, 'action' => 'remove'],
        '/carrito/actualizar' => ['controller' => CartController::class, 'action' => 'updateQuantity'],
        '/checkout' => ['controller' => CartController::class, 'action' => 'checkout'],
        '/stripe/webhook' => ['controller' => CartController::class, 'action' => 'stripeWebhook'],
    ],
];
