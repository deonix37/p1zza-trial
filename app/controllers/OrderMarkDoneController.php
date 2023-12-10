<?php

namespace App\Controllers;

use App\ApiController;
use App\Models\Order;

class OrderMarkDoneController extends ApiController
{
    private ?array $order;

    public function handle(): mixed
    {
        Order::markDone($this->params['order_id']);

        http_response_code(204);

        return null;
    }

    protected function validateExists(): bool
    {
        $this->order = Order::getOneById($this->params['order_id']);

        return (bool) $this->order;
    }

    protected function validate(): ?string
    {
        $authKey = $_SERVER['HTTP_X_AUTH_KEY'] ?? null;

        if ($this->order['done']) {
            return "Can't update when the order is done";
        }

        if ($authKey !== $_ENV['AUTH_KEY']) {
            return 'Invalid auth key';
        }

        return null;
    }
}
