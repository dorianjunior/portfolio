<?php

namespace App\Models;

class Project
{
    public string $id;
    public string $title;
    public string $slug;
    public string $description;
    public string $fullDescription;
    public array $technologies;
    public string $image;
    public ?string $githubUrl;
    public ?string $liveUrl;
    public string $date;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? uniqid();
        $this->title = $data['title'];
        $this->slug = $data['slug'] ?? $this->generateSlug($data['title']);
        $this->description = $data['description'];
        $this->fullDescription = $data['fullDescription'] ?? $data['description'];
        $this->technologies = $data['technologies'] ?? [];
        $this->image = $data['image'] ?? '/assets/img/default-project.jpg';
        $this->githubUrl = $data['githubUrl'] ?? null;
        $this->liveUrl = $data['liveUrl'] ?? null;
        $this->date = $data['date'] ?? date('Y-m-d');
    }

    /**
     * Gera um slug a partir do título
     */
    private function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }

    /**
     * Retorna todos os projetos (exemplo estático - pode ser substituído por banco de dados)
     */
    public static function all(): array
    {
        return [
            new self([
                'title' => 'Sistema de E-commerce',
                'description' => 'Plataforma completa de e-commerce com carrinho, pagamentos e painel administrativo.',
                'fullDescription' => 'Sistema completo de e-commerce desenvolvido em PHP com Laravel, incluindo integração com gateway de pagamento, gestão de estoque, painel administrativo completo e área do cliente.',
                'technologies' => ['PHP', 'Laravel', 'MySQL', 'Bootstrap', 'JavaScript'],
                'image' => '/assets/img/projects/ecommerce.jpg',
                'githubUrl' => 'https://github.com/seu-usuario/ecommerce',
                'liveUrl' => 'https://demo-ecommerce.com',
                'date' => '2023-06-15'
            ]),
            new self([
                'title' => 'API RESTful',
                'description' => 'API REST completa com autenticação JWT e documentação Swagger.',
                'fullDescription' => 'API RESTful desenvolvida seguindo as melhores práticas, com autenticação JWT, documentação interativa com Swagger, testes automatizados e deploy em Docker.',
                'technologies' => ['PHP', 'Slim Framework', 'JWT', 'MySQL', 'Docker'],
                'image' => '/assets/img/projects/api.jpg',
                'githubUrl' => 'https://github.com/seu-usuario/api-rest',
                'date' => '2023-09-20'
            ]),
            new self([
                'title' => 'Sistema de Gestão',
                'description' => 'Sistema de gestão empresarial com módulos de CRM, vendas e relatórios.',
                'fullDescription' => 'Sistema completo de gestão empresarial com módulos integrados de CRM, controle de vendas, gestão de clientes, relatórios gerenciais e dashboard interativo.',
                'technologies' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Chart.js'],
                'image' => '/assets/img/projects/gestao.jpg',
                'githubUrl' => 'https://github.com/seu-usuario/sistema-gestao',
                'liveUrl' => 'https://demo-gestao.com',
                'date' => '2023-11-10'
            ]),
        ];
    }

    /**
     * Encontra um projeto pelo slug
     */
    public static function findBySlug(string $slug): ?self
    {
        $projects = self::all();
        foreach ($projects as $project) {
            if ($project->slug === $slug) {
                return $project;
            }
        }
        return null;
    }
}
