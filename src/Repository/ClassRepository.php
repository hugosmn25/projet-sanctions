<?php
namespace App\Repository;

use PDO;

class ClassRepository
{
    private PDO $pdo;
    private string $table = 'classes';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée une classe.
     * @param array $data ['name'=>'...', 'level'=>'...']
     * @return int|false inserted id or false
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (`name`, `level`) VALUES (:name, :level)";
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute([
            ':name' => $data['name'],
            ':level' => $data['level'],
        ]);
        if ($res) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Retourne toutes les classes triées par level puis name.
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT id, name, level, DATE_FORMAT(created_at, '%d/%m/%Y à %H:%i') AS created_at FROM {$this->table} ORDER BY level ASC, name ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Trouve par id.
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT id, name, level, created_at FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Vérifie si une classe avec le même nom existe (optionnel)
     */
    public function existsByName(string $name): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $name]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    /**
     * Compte le nombre total de classes.
     * @return int
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
}