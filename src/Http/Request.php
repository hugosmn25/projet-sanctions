<?php
namespace App\Http;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private string $method;

    public function __construct()
    {
        $this->get = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->server = $_SERVER ?? [];
        $this->method = isset($this->server['REQUEST_METHOD']) ? strtoupper($this->server['REQUEST_METHOD']) : 'GET';
    }

    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

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

    public function getAction(): ?string
    {
        return $this->get('action', null);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->get) || array_key_exists($key, $this->post);
    }
}