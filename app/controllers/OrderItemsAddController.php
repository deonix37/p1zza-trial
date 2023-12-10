<?php

namespace App\Controllers;

use App\ApiController;
use App\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemsAddController extends ApiController
{
    private ?array $order;

    public function handle(): mixed
    {
        $itemQuantities = array_count_values($this->jsonInput);

        DB::$conn->beginTransaction();

        foreach ($itemQuantities as $itemId => $quantity) {
            OrderItem::createOrUpdate(
                $this->params['order_id'],
                $itemId,
                $quantity
            );
        }

        DB::$conn->commit();

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
        if ($this->order['done']) {
            return "Can't update when the order is done";
        }

        if (
            empty($this->jsonInput)
            || !is_array($this->jsonInput)
            || array_filter($this->jsonInput, function ($id) {
                return !is_int($id) || $id < 1 || $id > 5000;
            })
        ) {
            return 'Invalid items';
        }

        return null;
    }
}
