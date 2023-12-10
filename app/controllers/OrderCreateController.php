<?php

namespace App\Controllers;

use App\ApiController;
use App\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderCreateController extends ApiController
{
    public function handle(): mixed
    {
        $itemQuantities = array_count_values($this->jsonInput['items']);

        DB::$conn->beginTransaction();

        $orderId = Order::create();

        foreach ($itemQuantities as $itemId => $quantity) {
            OrderItem::create(
                $orderId,
                $itemId,
                $quantity
            );
        }

        DB::$conn->commit();

        http_response_code(201);

        return [
            'order_id' => $orderId,
            'items' => $this->jsonInput['items'],
            'done' => false,
        ];
    }

    protected function validate(): ?string
    {
        if (
            empty($this->jsonInput['items'])
            || !is_array($this->jsonInput['items'])
            || array_filter($this->jsonInput['items'], function ($id) {
                return !is_int($id) || $id < 1 || $id > 5000;
            })
        ) {
            return 'Invalid field items';
        }

        return null;
    }
}
