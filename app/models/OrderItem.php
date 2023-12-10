<?php

namespace App\Models;

use App\DB;

class OrderItem
{
    public static function getByOrderId(string $orderId): array
    {
        $stmt = DB::$conn->prepare(
            "SELECT *
            FROM `order_items`
            WHERE `order_id` = :order_id",
        );
        $stmt->bindParam('order_id', $orderId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function itemsIdsToArray(array $items): array
    {
        return array_reduce($items, function ($acc, $cur) {
            $nums = array_fill(0, $cur['quantity'], $cur['order_item_id']);

            return array_merge($acc, $nums);
        }, []);
    }

    public static function create(
        string $orderId,
        string $orderItemId,
        int $quantity
    ): void
    {
        DB::$conn->prepare(
            "INSERT INTO `order_items` (
                `order_id`,
                `order_item_id`,
                `quantity`
            )
            VALUES (?, ?, ?)",
        )->execute([$orderId, $orderItemId, $quantity]);
    }

    public static function createOrUpdate(
        string $orderId,
        string $orderItemId,
        int $quantity
    ): void
    {
        DB::$conn->prepare(
            "INSERT INTO `order_items` (
                `order_id`,
                `order_item_id`,
                `quantity`
            )
            VALUES (:order_id, :order_item_id, :quantity)
            ON DUPLICATE KEY UPDATE
            `quantity` = `quantity` + :quantity",
        )->execute([
            'order_id' => $orderId,
            'order_item_id' => $orderItemId,
            'quantity' => $quantity,
        ]);
    }
}
