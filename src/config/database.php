<?php
namespace App\Config;

use PDO;
use PDOException;

/**
 * Database connection helper with sensible dev fallbacks.
 *
 * It prefers environment variables (DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS).
 * If they are not set it will try common local/dev combos to make switching WAMP <-> Docker easier.
 */
class Database
{
    public static function getConnection(): PDO
    {
        // Read env first
        $envHost = getenv('DB_HOST') !== false ? getenv('DB_HOST') : null;
        $envPort = getenv('DB_PORT') !== false ? getenv('DB_PORT') : null;
        $envName = getenv('DB_NAME') !== false ? getenv('DB_NAME') : null;
        $envUser = getenv('DB_USER') !== false ? getenv('DB_USER') : null;
        $envPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : null;

        // Defaults (safe for local WAMP dev)
        $defaults = [
            'host' => $envHost ?? '127.0.0.1',
            'port' => $envPort ?? '3306',
            'name' => $envName ?? 'db_sanctions',
            'user' => $envUser ?? 'user',
            'pass' => $envPass ?? 'secret',
            'charset' => 'utf8mb4',
        ];

        $db = [];

        // If env provided, try that first
        if ($envHost !== null || $envPort !== null) {
            $db[] = [$defaults['host'], $defaults['port']];
        }
        
        $db[] = ['127.0.0.1', '3330'];

        $lastException = null;

        foreach ($db as [$host, $port]) {
            $dsn = "mysql:host={$host};port={$port};dbname={$defaults['name']};charset={$defaults['charset']}";
            try {
                $pdo = new PDO($dsn, $defaults['user'], $defaults['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // optional: persistent => false
                ]);
                return $pdo;
            } catch (PDOException $e) {
                // keep last exception for final message
                $lastException = $e;
                // try next candidate
            }
        }

        // If we arrive here, none of the candidates worked
        $msg = "Erreur de connexion à la base de données. Tentatives :\n";
        foreach ($db as [$h, $p]) {
            $msg .= "- $h:$p (db={$defaults['name']}, user={$defaults['user']})\n";
        }
        $msg .= "Dernier message MySQL: " . ($lastException ? $lastException->getMessage() : 'aucune réponse');

        throw new \RuntimeException($msg);
    }
}