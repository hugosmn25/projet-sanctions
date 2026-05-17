<?php
namespace App\Http;

/**
 * La classe Response (La Réponse)
 * Analogie : C'est "l'assiette finale" ramenée au client, ou les instructions de sortie.
 * Elle permet d'envoyer des codes d'état (ex: 200 OK, 404 Introuvable) 
 * et surtout de gérer les redirections de manière propre (Architecture Objet).
 */
class Response
{
    private int $statusCode = 200; // Par défaut, tout va bien
    private array $headers = [];

    /**
     * Définit le code HTTP renvoyé au navigateur
     */
    public function setStatusCode(int $code)
    {
        $this->statusCode = $code;
        http_response_code($code);
    }

    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
        header("$name: $value");
    }

    /**
     * La méthode la plus importante du fichier !
     * Très utilisée dans les Contrôleurs : après avoir validé un formulaire (ex: ajout d'élève),
     * on utilise $response->redirect('?action=liste_eleves') pour expulser l'utilisateur
     * vers le tableau plutôt que de le laisser sur la page de traitement.
     */
    public function redirect(string $url, int $status = 302)
    {
        $this->setStatusCode($status);
        header('Location: ' . $url);
        exit; // On stoppe net l'exécution du script PHP après une redirection
    }
}