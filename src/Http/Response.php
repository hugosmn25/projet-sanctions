<?php
namespace App\Http;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];

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

    public function redirect(string $url, int $status = 302)
    {
        $this->setStatusCode($status);
        header('Location: ' . $url);
        exit;
    }
}