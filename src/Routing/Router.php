<?php
namespace App\Routing;

/**
 * Router basique conforme aux consignes.
 * Gère les routes 'action' => fonction et vérifie méthodes HTTP.
 */
class Router
{
    private array $routes = [];
    private $request;
    private $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Ajoute une route
     * @param string $action
     * @param callable|string|array $fonction
     * @param array $methodes
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

    public function handleRequest(): void
    {
        $method = strtoupper(method_exists($this->request, 'getMethod') ? $this->request->getMethod() : ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
        $action = method_exists($this->request, 'getAction') ? ($this->request->getAction() ?? 'index') : ($_GET['action'] ?? 'index');

        if (!$this->hasRoute($action)) {
            $this->handleNotFound();
            return;
        }

        $route = $this->routes[$action];

        if (!in_array($method, $route['methodes'])) {
            $this->handleMethodNotAllowed($route['methodes']);
            return;
        }

        $fonction = $route['fonction'];

        // Determine callable
        $callable = null;
        if (is_callable($fonction)) {
            $callable = $fonction;
        } elseif (is_string($fonction) && function_exists($fonction)) {
            $callable = $fonction;
        } elseif (is_array($fonction) && count($fonction) === 2) {
            // ['ClassOrInstance', 'method']
            $callable = $fonction;
        }

        if ($callable === null) {
            $this->handleFunctionNotFound();
            return;
        }

        // Call with 0/1/2 arguments depending on expected parameters
        try {
            if (is_array($callable)) {
                $ref = new \ReflectionMethod($callable[0], $callable[1]);
            } else {
                $ref = new \ReflectionFunction($callable);
            }
            $numParams = $ref->getNumberOfParameters();
            $args = [];
            if ($numParams >= 1) $args[] = $this->request;
            if ($numParams >= 2) $args[] = $this->response;

            call_user_func_array($callable, $args);
        } catch (\Throwable $e) {
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