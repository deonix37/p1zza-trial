<?php

namespace App;

class DB
{
    public static ?\PDO $conn = null;

    public static function connect(): void
    {
        self::$conn = new \PDO(
            "mysql:host=mysql;dbname=$_ENV[DB_DATABASE]",
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD'],
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]
        );
    }
}
