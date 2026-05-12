<?php
namespace App\Repository;

use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->init();
    }

    /**
     * Création de la table utilisateur en MySQL
     */
    private function init(): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    prenom VARCHAR(100) DEFAULT NULL,
    nom VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;

        $this->pdo->exec($sql);
    }

    /**
     * Retourne un utilisateur via son email
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    /**
     * Retourne un utilisateur via son id
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO utilisateur (email, password, prenom, nom)
             VALUES (:email, :password, :prenom, :nom)'
        );

        return $stmt->execute([
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':prenom' => $data['prenom'] ?? null,
            ':nom' => $data['nom'] ?? null,
        ]);
    }

    /**
     * Retourne le nombre total d'utilisateurs
     */
    public function countAll(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM utilisateur');
        return (int) $stmt->fetchColumn();
    }
}
