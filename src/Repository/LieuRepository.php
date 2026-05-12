<?php
namespace App\Repository;
use PDO;

class LieuRepository {
    private PDO $pdo;
    private string $table = 'lieux';

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les lieux
    public function findAll(): array {
        $sql = "SELECT id, nom FROM {$this->table} ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Créer un lieu
    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (nom) VALUES (:nom)";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([':nom' => $data['nom']])) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }
}