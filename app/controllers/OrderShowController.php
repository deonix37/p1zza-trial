<?php

namespace App\Controllers;

use App\ApiController;
use App\Models\Order;
use App\Models\OrderItem;

class OrderShowController extends ApiController
{
    private ?array $order;

    public function handle(): mixed
    {
        $items = OrderItem::getByOrderId($this->params['order_id']);

        return [
            'order_id' => $this->order['order_id'],
            'items' => OrderItem::itemsIdsToArray($items),
            'done' => (bool) $this->order['done'],
        ];
    }

    protected function validateExists(): bool
    {
        $this->order = Order::getOneById($this->params['order_id']);

        return (bool) $this->order;
    }
}
