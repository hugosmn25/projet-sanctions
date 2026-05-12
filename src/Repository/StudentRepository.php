<?php
namespace App\Repository;

use PDO;

class StudentRepository
{
    private PDO $pdo;
    private string $table = 'students';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée un élève.
     * @param array $data ['nom'=>'','prenom'=>'','date_naissance'=>'YYYY-MM-DD','classe_id'=>int]
     * @return int|false inserted id or false
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (nom, prenom, date_naissance, classe_id) VALUES (:nom, :prenom, :date_naissance, :classe_id)";
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':date_naissance' => $data['date_naissance'],
            ':classe_id' => $data['classe_id'],
        ]);
        if ($res) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Retourne tous les élèves triés par classe puis nom.
     * Implémente jointure pour inclure le nom de la classe et le niveau.
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT s.id, s.nom, s.prenom, DATE_FORMAT(s.date_naissance, '%d/%m/%Y') AS date_naissance, 
                       c.name AS class_name, c.level AS level, DATE_FORMAT(s.created_at, '%d/%m/%Y à %H:%i') AS created_at
                FROM {$this->table} s
                LEFT JOIN classes c ON s.classe_id = c.id
                ORDER BY c.name ASC, s.nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Retourne la liste des classes pour utiliser dans les selects (id,name).
     */
    public function findClassesList(): array
    {
        $sql = "SELECT id, name FROM classes ORDER BY level ASC, name ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Vérifie qu'une classe existe (par id)
     */
    public function classExists(int $id): bool
    {
        $sql = "SELECT COUNT(*) FROM classes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    /**
     * Compte le nombre total d'élèves.
     * @return int
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
}