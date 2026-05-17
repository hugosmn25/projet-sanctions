<?php
namespace App\Routing;

/**
 * Router basique conforme aux consignes.
 * Analogie : C'est le "chef de salle" ou "l'aiguilleur".
 * Il lit l'action dans l'URL et décide à quel Contrôleur confier le travail.
 */
class Router
{
    private array $routes = []; // Le catalogue de toutes les pages existantes
    private $request;
    private $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Ajoute une route au catalogue (Généralement appelé depuis public/index.php)
     * @param string $action Le nom de l'action dans l'URL (ex: 'liste_sanctions')
     * @param callable|string|array $fonction Le Contrôleur et la méthode à appeler
     * @param array $methodes S'agit-il d'un simple affichage (GET) ou d'un formulaire (POST) ?
     * @return $this
     */
    public function addRoute($action, $fonction, $methodes = ['GET']): self
    {
        $methodes = array_map('strtoupper', (array)$methodes);
        $this->routes[$action] = [
            'fonction' => $fonction,
            'methodes' => $methodes,
        ];
        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function hasRoute($action): bool
    {
        return isset($this->routes[$action]);
    }

    /**
     * Le cœur du Routeur : la méthode qui analyse l'URL et lance le Contrôleur
     */
    public function handleRequest(): void
    {
        // 1. On regarde ce que le client demande (GET ou POST) et l'action (ex: ?action=login)
        $method = strtoupper(method_exists($this->request, 'getMethod') ? $this->request->getMethod() : ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
        $action = method_exists($this->request, 'getAction') ? ($this->request->getAction() ?? 'index') : ($_GET['action'] ?? 'index');

        // 2. Si l'action n'existe pas dans le catalogue, on déclenche une erreur 404 (Page introuvable)
        if (!$this->hasRoute($action)) {
            $this->handleNotFound();
            return;
        }

        $route = $this->routes[$action];

        // 3. Si on essaie d'envoyer un POST sur une route qui n'accepte que du GET (ou inversement)
        if (!in_array($method, $route['methodes'])) {
            $this->handleMethodNotAllowed($route['methodes']);
            return;
        }

        $fonction = $route['fonction'];

        // Determine callable (préparation de la fonction du contrôleur à lancer)
        $callable = null;
        if (is_callable($fonction)) {
            $callable = $fonction;
        } elseif (is_string($fonction) && function_exists($fonction)) {
            $callable = $fonction;
        } elseif (is_array($fonction) && count($fonction) === 2) {
            // ['ClassOrInstance', 'method'] -> C'est ce cas de figure qui est utilisé dans ton index.php
            $callable = $fonction;
        }

        if ($callable === null) {
            $this->handleFunctionNotFound();
            return;
        }

        // 4. L'exécution réelle : on lance la méthode du Contrôleur en lui passant la Request et la Response
        try {
            if (is_array($callable)) {
                $ref = new \ReflectionMethod($callable[0], $callable[1]);
            } else {
                $ref = new \ReflectionFunction($callable);
            }
            $numParams = $ref->getNumberOfParameters();
            $args = [];
            // Si le Contrôleur a besoin de la Request ou de la Response, on les lui donne
            if ($numParams >= 1) $args[] = $this->request;
            if ($numParams >= 2) $args[] = $this->response;

            call_user_func_array($callable, $args); // <-- C'est ici que le code du Contrôleur est exécuté !
            
        } catch (\Throwable $e) {
            // Si le Contrôleur plante (erreur SQL, bug PHP), on affiche une erreur 500
            if (method_exists($this->response, 'setStatusCode')) {
                $this->response->setStatusCode(500);
            } else {
                http_response_code(500);
            }
            echo "Erreur interne: " . htmlspecialchars($e->getMessage());
            return;
        }

        if (method_exists($this->response, 'send')) {
            $this->response->send();
        }
    }

    // --- Méthodes de gestion d'erreurs ---

    private function handleNotFound(): void
    {
        if (method_exists($this->response, 'redirect')) {
            $this->response->redirect('?action=index', 302);
            if (method_exists($this->response, 'send')) $this->response->send();
        } else {
            header('Location: ?action=index', true, 302);
        }
        exit;
    }

    private function handleMethodNotAllowed(array $methodesAutorisees): void
    {
        $allowed = implode(', ', $methodesAutorisees);
        if (method_exists($this->response, 'setStatusCode')) {
            $this->response->setStatusCode(405);
            if (method_exists($this->response, 'setHeader')) {
                $this->response->setHeader('Allow', $allowed);
            }
            if (method_exists($this->response, 'send')) $this->response->send();
        } else {
            header('Allow: ' . $allowed);
            http_response_code(405);
            echo '405 Method Not Allowed. Allowed: ' . $allowed;
        }
        exit;
    }

    private function handleFunctionNotFound(): void
    {
        $this->handleNotFound();
    }
}