<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Infrastructure\Database;
use PDO;

class DoctorRepository
{
    private PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function findAll(): array
    {
        $sql = 'SELECT d.id_doctor, d.nombre, d.apellido, d.num_colegiado, d.id_hospital,
                       h.nombre_hospital
                FROM doctor d
                INNER JOIN hospital h ON d.id_hospital = h.id_hospital
                ORDER BY d.id_doctor ASC';

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO doctor (nombre, apellido, num_colegiado, id_hospital)
                VALUES (:nombre, :apellido, :num_colegiado, :id_hospital)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'num_colegiado' => $data['num_colegiado'],
            'id_hospital' => (int) $data['id_hospital'],
        ]);

        return (int) $this->db->lastInsertId();
    }
}
