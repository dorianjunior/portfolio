<?php

namespace App\Controllers;

use Twig\Environment;

abstract class Controller
{
    protected Environment $twig;
    protected array $env;

    public function __construct(array $config)
    {
        $this->twig = $config['twig'];
        $this->env = $config['env'];
    }

    /**
     * Renderiza uma view Twig
     */
    protected function render(string $view, array $data = []): string
    {
        // Adiciona dados globais que estarão disponíveis em todas as views
        $data['app_name'] = $this->env['APP_NAME'] ?? 'Portfólio';
        $data['app_url'] = $this->env['APP_URL'] ?? '';
        
        return $this->twig->render($view, $data);
    }

    /**
     * Redireciona para uma URL
     */
    protected function redirect(string $url, int $statusCode = 302): void
    {
        header("Location: $url", true, $statusCode);
        exit;
    }

    /**
     * Retorna resposta JSON
     */
    protected function json(array $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}
