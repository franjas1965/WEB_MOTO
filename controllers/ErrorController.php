<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;

class ErrorController extends Controller
{
    public function notFound(): void
    {
        http_response_code(404);
        $this->render('errors/404', [
            'pageTitle' => 'Página no encontrada | DrPitbike',
        ]);
    }
}
