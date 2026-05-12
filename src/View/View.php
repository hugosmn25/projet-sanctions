<?php
namespace App\View;

/**
 * Simple PHP view renderer
 */
class View
{
    private string $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = rtrim($templatesPath, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * Render a template (PHP) with variables
     *
     * @param string $name (without .php)
     * @param array $params
     */
    public function render(string $name, array $params = []): void
    {
        $file = $this->templatesPath . $name . '.php';
        if (!file_exists($file)) {
            echo "Template not found: " . htmlspecialchars($file);
            return;
        }
        extract($params, EXTR_SKIP);
        include $file;
    }
}