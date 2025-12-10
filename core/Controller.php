<?php

declare(strict_types=1);

namespace Core;

use PDO;
use Services\Auth;
use Services\Cart;

abstract class Controller
{
    private ?Auth $authService = null;
    private ?Cart $cartService = null;

    protected function render(string $view, array $params = [], ?string $layout = 'layouts/main'): void
    {
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException(sprintf('View %s not found', $view));
        }

        $config = App::config();
        $currentUser = $params['currentUser'] ?? $this->auth()->user();
        $flash = $params['flash'] ?? $this->getFlash();

        extract($params, EXTR_SKIP);

        if ($layout === null) {
            require $viewFile;
            return;
        }

        $layoutFile = __DIR__ . '/../views/' . $layout . '.php';

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException(sprintf('Layout %s not found', $layout));
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layoutFile;
    }

    protected function db(): PDO
    {
        return Database::getInstance(App::config('database'))->getConnection();
    }

    protected function auth(): Auth
    {
        return $this->authService ??= new Auth(App::config());
    }

    protected function cart(): Cart
    {
        return $this->cartService ??= new Cart(App::config());
    }

    protected function redirect(string $path): void
    {
        $baseUrl = rtrim((string) App::config('app.base_url'), '/');
        header('Location: ' . $baseUrl . $path);
        exit;
    }

    protected function requireMethod(string $method): void
    {
        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? '') !== strtoupper($method)) {
            http_response_code(405);
            exit;
        }
    }

    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function getFlash(): ?array
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }

    protected function requireAuth(?string $redirectTo = '/login'): array
    {
        $user = $this->auth()->user();

        if ($user === null) {
            $this->setFlash('warning', 'Necesitas iniciar sesión para continuar.');
            $this->redirect($redirectTo ?? '/login');
        }

        return $user;
    }

    protected function flashRedirect(string $type, string $message, string $path): void
    {
        $this->setFlash($type, $message);
        $this->redirect($path);
    }
}
