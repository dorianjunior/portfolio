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
                'title' => 'App Super Gestão',
                'description' => 'Sistema de gestão empresarial',
                'fullDescription' => 'Sistema web desenvolvido com Laravel 9 que oferece controle total sobre operações empresariais, incluindo gerenciamento de fornecedores, cadastro e controle de produtos, gestão de múltiplas filiais com preços diferenciados, base de clientes, formulário de contato público e painel administrativo com dashboard e estatísticas em tempo real. Conta com sistema de autenticação seguro e interface responsiva.',
                'technologies' => ['Laravel 9', 'PHP 8.2+', 'MySQL', 'Bootstrap', 'JavaScript', 'Blade Templates', 'Eloquent ORM', 'Authentication'],
                'image' => '/assets/img/projects/app_super_gestao.png',
                'githubUrl' => 'https://github.com/dorianjunior/app_super_gestao',
                'liveUrl' => 'https://appsupergestao.infinityfree.me/',
                'date' => '2022-07-15'
            ]),
            new self([
                'title' => 'Site MMGarden',
                'description' => 'Site institucional para a empresa MMGarden.',
                'fullDescription' => 'Site institucional para a empresa MMGarden, com informações sobre produtos e serviços.',
                'technologies' => ['Vue.js', 'HTML5', 'CSS3', 'JavaScript', 'SEO', 'Google Ads', 'Vercel'],
                'image' => '/assets/img/projects/mmgarden.png',
                'githubUrl' => 'https://github.com/dorianjunior/mmgarden',
                'liveUrl' => 'https://mmgarden.com.br',
                'date' => '2024-05-13'
            ]),
            new self([
                'title' => 'Site AJS Fogões',
                'description' => 'Site institucional para a empresa AJS Fogões.',
                'fullDescription' => 'Site institucional para a empresa AJS Fogões, com informações sobre produtos e serviços.',
                'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'SEO', 'Google Ads', 'Vercel'],
                'image' => '/assets/img/projects/ajsfogoes.png',
                'githubUrl' => 'https://github.com/dorianjunior/ajsfogoes',
                'liveUrl' => 'https://ajsfogoes.com.br',
                'date' => '2022-06-05'
            ]),
            new self([
                'title' => 'Site Amamentação Florianópolis',
                'description' => 'Site institucional para a empresa Amamentação Florianópolis.',
                'fullDescription' => 'Site institucional para a empresa Amamentação Florianópolis, com informações sobre cursos e serviços para mães e bebês.',
                'technologies' => ['Vue.js', 'HTML5', 'CSS3', 'JavaScript', 'SEO', 'Vercel'],
                'image' => '/assets/img/projects/amamentacao.png',
                'githubUrl' => 'https://github.com/dorianjunior/amamentacao',
                'liveUrl' => 'https://amamentacaoflorianopolis.com.br',
                'date' => '2025-08-23'
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
