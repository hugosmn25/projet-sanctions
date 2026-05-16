<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        // 1. Détection de l'environnement (Docker ou Localhost)
        // Si getenv('DB_HOST') est fourni par Docker, on l'utilise.
        // Sinon, c'est qu'on est en localhost sous Windows, donc on force '127.0.0.1'
        $host = getenv('DB_HOST') ?: '127.0.0.1';

        // 2. Gestion dynamique du Port
        // Si on est dans Docker, le serveur PHP parle à MySQL sur le port interne '3306'
        // Si on est en localhost sous Windows, on doit utiliser le port exposé '3330'
        if (getenv('DB_HOST') !== false) {
            $port = getenv('DB_PORT') ?: '3306';
        } else {
            $port = '3330'; // Ton port externe configuré dans le docker-compose.yml
        }

        // 3. Récupération des autres variables (communes)
        $name = getenv('DB_NAME') ?: 'db_sanctions';
        $user = getenv('DB_USER') ?: 'user';
        $pass = getenv('DB_PASS') ?: 'secret';

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

        try {
            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            
            return self::$connection;
        } catch (PDOException $e) {
            throw new \RuntimeException(
                "Erreur de connexion à la base de données (Mode: " . ($host === '127.0.0.1' ? 'Localhost' : 'Docker') . ").\n" .
                "Vérifiez que le conteneur de la BDD est bien démarré.\n" .
                "Détail : " . $e->getMessage()
            );
        }
    }
}