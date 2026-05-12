<?php
namespace App\Repository;

use PDO;

class SanctionRepository
{
    private PDO $pdo;
    private string $table = 'sanctions';

    /**
     * Types de sanctions autorisées (clé => libellé).
     *
     * @return array<string,string>
     */
    public static function getTypes(): array
    {
        return [
            'avertissement' => 'Avertissement',
            'retenue' => 'Retenue',
            'exclusion_temporaire' => 'Exclusion temporaire',
            'exclusion_definitive' => 'Exclusion définitive',
        ];
    }

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée une sanction.
     *
     * @param array $data ['date'=>'YYYY-MM-DD','motif'=>'','type'=>'key','professor_id'=>int,'student_id'=>int]
     * @return int|false id inséré ou false
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO {$this->table} (date, motif, type, professor_id, student_id)
                VALUES (:date, :motif, :type, :professor_id, :student_id)";
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute([
            ':date' => $data['date'],
            ':motif' => $data['motif'],
            ':type' => $data['type'],
            ':professor_id' => $data['professor_id'],
            ':student_id' => $data['student_id'],
        ]);

        if ($res) {
            return (int)$this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Récupère toutes les sanctions avec informations liées (professeur, élève, classe).
     *
     * @return array<int,array<string,mixed>>
     */
    public function findAll(): array
    {
        $sql = "SELECT s.id,
                       DATE_FORMAT(s.date, '%d/%m/%Y') AS date,
                       s.motif,
                       s.type,
                       p.id AS professor_id,
                       p.nom AS professor_nom,
                       p.prenom AS professor_prenom,
                       st.id AS student_id,
                       st.nom AS student_nom,
                       st.prenom AS student_prenom,
                       c.name AS class_name,
                       DATE_FORMAT(s.created_at, '%d/%m/%Y %H:%i') AS created_at
                FROM {$this->table} s
                LEFT JOIN professors p ON s.professor_id = p.id
                LEFT JOIN students st ON s.student_id = st.id
                LEFT JOIN classes c ON st.classe_id = c.id
                ORDER BY s.date DESC, s.id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Liste simplifiée des sanctions (id, date, motif).
     *
     * @return array<int,array<string,mixed>>
     */
    public function findList(): array
    {
        $sql = "SELECT id, DATE_FORMAT(date, '%d/%m/%Y') AS date, motif FROM {$this->table} ORDER BY date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Nombre total de sanctions.
     *
     * @return int
     */
    public function countAll(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return (int)$stmt->fetchColumn();
    }
}