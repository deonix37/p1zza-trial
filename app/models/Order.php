<?php

namespace App\Models;

use App\DB;

class Order
{
    public static function get(?bool $done = null): array
    {
        $sql = "SELECT `order_id`, `done` FROM `orders`";

        if (!is_null($done)) {
            $sql .= " WHERE `done` = :done";
        }

        $stmt = DB::$conn->prepare($sql);

        if (!is_null($done)) {
            $stmt->bindParam('done', $done);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getOneById(string $orderId): ?array
    {
        $stmt = DB::$conn->prepare(
            "SELECT *
            FROM `orders`
            WHERE `order_id` = :order_id",
        );
        $stmt->bindParam('order_id', $orderId);
        $stmt->execute();

        return $stmt->fetch() ?: null;
    }

    public static function create(): string
    {
        $id = substr(sha1(rand()), 0, random_int(3, 15));

        DB::$conn->prepare(
            "INSERT INTO `orders` (`order_id`, `done`)
            VALUES (?, ?)",
        )->execute([$id, 0]);

        return $id;
    }

    public static function markDone(string $orderId): void
    {
        DB::$conn->prepare(
            "UPDATE `orders`
            SET `done` = 1
            WHERE `order_id` = ?",
        )->execute([$orderId]);
    }
}
