<?php
namespace App\Http;

/**
 * La classe Request (La Requête)
 * Analogie : C'est le "bon de commande" écrit par le client.
 * Elle capture toutes les données envoyées par le navigateur (URL, formulaires)
 * et les met au propre pour faciliter le travail du Contrôleur.
 */
class Request
{
    private array $get;
    private array $post;
    private array $server;
    private string $method;

    public function __construct()
    {
        // On récupère les variables superglobales de PHP au moment du clic
        $this->get = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->server = $_SERVER ?? [];
        // On détermine si l'utilisateur charge une page (GET) ou soumet un formulaire (POST)
        $this->method = isset($this->server['REQUEST_METHOD']) ? strtoupper($this->server['REQUEST_METHOD']) : 'GET';
    }

    /**
     * Permet de lire un paramètre dans l'URL (ex: ?id=5)
     */
    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

    /**
     * Permet de lire un champ d'un formulaire (ex: le <input name="motif">)
     */
    public function post(string $key, $default = null)
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
    }

    public function allPost(): array
    {
        return $this->post;
    }

    public function allGet(): array
    {
        return $this->get;
    }

    /**
     * Méthode très utilisée dans les Contrôleurs :
     * Permet de savoir d'un seul coup si le formulaire vient d'être validé.
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Récupère la valeur de '?action=' dans l'URL.
     * C'est ce qui permet au Routeur de savoir quelle page charger.
     */
    public function getAction(): ?string
    {
        return $this->get('action', null);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->get) || array_key_exists($key, $this->post);
    }
}