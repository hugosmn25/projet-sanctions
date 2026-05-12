<?php
namespace App\Repository;

use PDO;

class ProfessorRepository
{
    private PDO $pdo;
    private string $table = 'professors';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée un professeur.
     * @param array $data ['nom'=>'','prenom'=>'','matiere'=>'']
     * @return int|false inserted id or false
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (nom, prenom, matiere) VALUES (:nom, :prenom, :matiere)";
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':matiere' => $data['matiere'],
        ]);
        if ($res) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Retourne tous les professeurs triés par nom.
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT id, nom, prenom, matiere, DATE_FORMAT(created_at, '%d/%m/%Y à %H:%i') AS created_at
                FROM {$this->table}
                ORDER BY nom ASC, prenom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Retourne la liste simplifiée des professeurs pour les selects (id, nom, prenom).
     * Utile pour US13 (sélection du professeur).
     * @return array
     */
    public function findList(): array
    {
        $sql = "SELECT id, nom, prenom, matiere FROM {$this->table} ORDER BY nom ASC, prenom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Vérifie qu'un professeur existe (par id)
     */
    public function exists(int $id): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    /**
     * Compte le nombre total de professeurs.
     * @return int
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
}