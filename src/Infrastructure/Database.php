<?php

declare(strict_types=1);

namespace App\Infrastructure;

use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct(
        string $host,
        string $dbname,
        string $user,
        string $password,
        int $port = 3306
    ) {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

        try {
            $this->connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new PDOException('Error de conexion a la base de datos: ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
