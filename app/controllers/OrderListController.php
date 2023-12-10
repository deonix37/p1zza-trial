<?php

namespace App\Controllers;

use App\ApiController;
use App\Models\Order;

class OrderListController extends ApiController
{
    public function handle(): mixed
    {
        $done = $_GET['done'] ?? null;

        return array_map(function ($order) {
            return [
                'order_id' => $order['order_id'],
                'done' => (bool) $order['done'],
            ];
        }, Order::get($done));
    }

    protected function validate(): ?string
    {
        $authKey = $_SERVER['HTTP_X_AUTH_KEY'] ?? null;

        if ($authKey !== $_ENV['AUTH_KEY']) {
            return 'Invalid auth key';
        }

        if (isset($_GET['done']) && !in_array($_GET['done'], [0, 1])) {
            return 'Invalid parameter done';
        }

        return null;
    }
}
