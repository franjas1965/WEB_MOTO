<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class AuthController extends Controller
{
    public function showLoginForm(): void
    {
        $this->render('auth/login', [
            'pageTitle' => 'Accede a tu cuenta | DrPitbike',
        ]);
    }

    public function showRegisterForm(): void
    {
        $this->render('auth/register', [
            'pageTitle' => 'Únete a la comunidad | DrPitbike',
        ]);
    }

    public function login(): void
    {
        $this->requireMethod('POST');

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->flashRedirect('danger', 'Completa tus credenciales.', '/login');
        }

        if (!$this->auth()->attemptLogin($email, $password)) {
            $this->flashRedirect('danger', 'Credenciales inválidas.', '/login');
        }

        $this->flashRedirect('success', 'Bienvenido de nuevo.', '/area-cliente');
    }

    public function register(): void
    {
        $this->requireMethod('POST');

        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'password' => $_POST['password'] ?? '',
        ];

        if ($data['nombre'] === '' || $data['email'] === '' || $data['password'] === '') {
            $this->flashRedirect('danger', 'Completa todos los campos obligatorios.', '/registro');
        }

        try {
            $this->auth()->register($data);
        } catch (\Throwable $throwable) {
            $this->flashRedirect('danger', $throwable->getMessage(), '/registro');
        }

        $this->flashRedirect('success', 'Cuenta creada. Inicia sesión ahora.', '/login');
    }

    public function logout(): void
    {
        $this->requireMethod('POST');

        $this->auth()->logout();
        $this->flashRedirect('success', 'Sesión cerrada correctamente.', '/');
    }
}
