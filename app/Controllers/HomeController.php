<?php

namespace App\Controllers;

class HomeController extends Controller
{
    /**
     * Página inicial
     */
    public function index(): string
    {
        $data = [
            'title' => $this->trans('home.title'),
            'description' => $this->trans('home.description'),
            'skills' => [
                'PHP' => 90,
                'JavaScript' => 85,
                'Laravel' => 88,
                'MySQL' => 80,
                'HTML/CSS' => 95,
                'Git' => 85,
            ],
            'social' => [
                'github' => 'https://github.com/dorianjunior',
                'linkedin' => 'https://linkedin.com/in/dorianjunior',
                'email' => 'dorianc.vieira@gmail.com',
            ]
        ];

        return $this->render('home.twig', $data);
    }

    /**
     * Página sobre mim
     */
    public function about(): string
    {
        $data = [
            'title' => $this->trans('about.title'),
            'description' => $this->trans('about.description'),
            'bio' => $this->trans('about.bio'),
            'experience' => [
                [
                    'title' => 'Desenvolvedor Full Stack',
                    'company' => 'Empresa XYZ',
                    'period' => '2022 - Presente',
                    'description' => 'Desenvolvimento de aplicações web...'
                ],
                // Adicione mais experiências conforme necessário
            ],
            'education' => [
                [
                    'degree' => 'Graduação em Ciência da Computação',
                    'institution' => 'Universidade ABC',
                    'period' => '2018 - 2022',
                ],
                // Adicione mais formações conforme necessário
            ]
        ];

        return $this->render('about.twig', $data);
    }
}
