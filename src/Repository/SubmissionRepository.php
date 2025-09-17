<?php

namespace App\Repository;

use App\Service\DatabaseService;
use PDO;

class SubmissionRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getConnection();
    }

    /**
     * Salva uma nova submissão no banco de dados.
     */
    public function save(array $data): bool
    {
        $sql = "INSERT INTO submissions (name, email, phone, desired_position, education_level, observations, file_path, ip_address, submitted_at) 
                VALUES (:name, :email, :phone, :desired_position, :education_level, :observations, :file_path, :ip_address, :submitted_at)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':desired_position' => $data['desired_position'],
            ':education_level' => $data['education_level'],
            ':observations' => $data['observations'],
            ':file_path' => $data['file_path'],
            ':ip_address' => $data['ip_address'],
            ':submitted_at' => $data['submitted_at'],
        ]);
    }
}
