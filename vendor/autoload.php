<?php
/**
 * Simple project autoloader - Version optimisée
 *
 * Enregistre un autoloader PSR-4 pour le namespace "App\" -> src/
 * Sans dépendance à Composer
 */

spl_autoload_register(function (string $class) {
    // Namespace principal du projet
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../src/';

    // Si la classe utilise le namespace App\, on charge depuis src/
    if (strncmp($prefix, $class, strlen($prefix)) === 0) {
        $relativeClass = substr($class, strlen($prefix));
        $file = $baseDir .  str_replace('\\', '/', $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require $file;
        }
    }
});