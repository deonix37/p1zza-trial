<?php

namespace App\Controllers;

use App\ApiController;
use App\Models\Order;

class OrderListController extends ApiController
{
    private array $query = [
        'done' => null,
    ];

    public function handle(): mixed
    {
        return array_map(function ($order) {
            return [
                'order_id' => $order['order_id'],
                'done' => (bool) $order['done'],
            ];
        }, Order::get($this->query['done']));
    }

    protected function validate(): ?string
    {
        $authKey = $_SERVER['HTTP_X_AUTH_KEY'] ?? null;

        if ($authKey !== $_ENV['AUTH_KEY']) {
            return 'Invalid auth key';
        }

        if (isset($_GET['done'])) {
            if (!in_array($_GET['done'], [0, 1])) {
                return 'Invalid parameter done';
            }

            $this->query['done'] = (bool) $_GET['done'];
        }

        return null;
    }
}
