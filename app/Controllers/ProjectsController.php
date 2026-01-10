<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    /**
     * Lista todos os projetos
     */
    public function index(): string
    {
        $projects = Project::all();

        $data = [
            'title' => 'Meus Projetos',
            'description' => 'Confira alguns dos projetos que desenvolvi',
            'projects' => $projects,
        ];

        return $this->render('projects.twig', $data);
    }

    /**
     * Exibe detalhes de um projeto específico
     */
    public function show(array $vars): string
    {
        $slug = $vars['slug'] ?? '';
        $project = Project::findBySlug($slug);

        if (!$project) {
            http_response_code(404);
            return $this->render('errors/404.twig', [
                'title' => 'Projeto não encontrado',
                'message' => 'O projeto que você está procurando não existe.'
            ]);
        }

        $data = [
            'title' => $project->title,
            'description' => $project->description,
            'project' => $project,
        ];

        return $this->render('project-detail.twig', $data);
    }
}
