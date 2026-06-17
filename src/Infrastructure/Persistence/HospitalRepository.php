<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Database;
use PDO;

class HospitalRepository
{
    private PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function findById(int $id): ?array
    {
        $sql = 'SELECT h.id_hospital, h.nombre_hospital, h.direccion, h.telefono,
                       h.id_especialidad, e.nombre_especialidad
                FROM hospital h
                INNER JOIN especialidad e ON h.id_especialidad = e.id_especialidad
                WHERE h.id_hospital = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $hospital = $stmt->fetch();

        return $hospital ?: null;
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO hospital (nombre_hospital, direccion, telefono, id_especialidad)
                VALUES (:nombre_hospital, :direccion, :telefono, :id_especialidad)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nombre_hospital' => $data['nombre_hospital'],
            'direccion' => $data['direccion'],
            'telefono' => $data['telefono'],
            'id_especialidad' => (int) $data['id_especialidad'],
        ]);

        return (int) $this->db->lastInsertId();
    }
}
