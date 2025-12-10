<?php

declare(strict_types=1);

namespace Controllers;

use Core\Controller;
use Throwable;

class CartController extends Controller
{
    public function index(): void
    {
        $user = $this->auth()->user();
        $cart = $this->cart();
        $totals = $cart->totals($user);

        $this->render('cart/index', [
            'pageTitle' => 'Tu carrito | DrPitbike',
            'totals' => $totals,
            'cartItems' => $totals['items'],
        ]);
    }

    public function add(): void
    {
        $this->requireMethod('POST');

        $type = $_POST['type'] ?? 'event';

        try {
            if ($type === 'event') {
                $eventId = (int) ($_POST['event_id'] ?? 0);
                $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
                $this->cart()->addEvent($eventId, $quantity);
                $this->flashRedirect('success', 'Rodada añadida al carrito.', '/carrito');
                return;
            }

            if ($type === 'product') {
                $productId = (int) ($_POST['product_id'] ?? 0);
                $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
                $eventId = isset($_POST['event_id']) ? (int) $_POST['event_id'] : null;
                $this->cart()->addProduct($productId, $quantity, $eventId);
                $this->flashRedirect('success', 'Producto añadido al carrito.', '/carrito');
                return;
            }
        } catch (Throwable $throwable) {
            $this->flashRedirect('danger', $throwable->getMessage(), $_SERVER['HTTP_REFERER'] ?? '/carrito');
        }

        $this->flashRedirect('danger', 'Tipo de ítem no reconocido.', '/carrito');
    }

    public function remove(): void
    {
        $this->requireMethod('POST');

        $itemKey = $_POST['item_key'] ?? '';
        $this->cart()->remove($itemKey);

        $this->flashRedirect('success', 'Ítem eliminado del carrito.', '/carrito');
    }

    public function updateQuantity(): void
    {
        $this->requireMethod('POST');

        $itemKey = $_POST['item_key'] ?? '';
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

        try {
            $this->cart()->updateQuantity($itemKey, $quantity);
        } catch (Throwable $throwable) {
            $this->flashRedirect('danger', $throwable->getMessage(), '/carrito');
        }

        $this->flashRedirect('success', 'Cantidad actualizada.', '/carrito');
    }

    public function checkout(): void
    {
        $this->requireMethod('POST');

        $user = $this->requireAuth('/login');
        $totals = $this->cart()->totals($user);

        if (empty($totals['items'])) {
            $this->flashRedirect('warning', 'Tu carrito está vacío.', '/carrito');
        }

        // TODO: Integrate Stripe Checkout session creation here.
        $this->flashRedirect('info', 'Integración de pago pendiente. Se redireccionará a Stripe.', '/carrito');
    }

    public function stripeWebhook(): void
    {
        $this->requireMethod('POST');

        // TODO: Implement Stripe webhook validation and membership activation.
        http_response_code(200);
    }
}
