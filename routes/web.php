<?php

use App\Controllers\HomeController;
use App\Controllers\ProjectsController;
use App\Controllers\ContactController;
use FastRoute\RouteCollector;

/** @var RouteCollector $r */

// Rota raiz - redireciona para idioma padrão
$r->addRoute('GET', '/', [HomeController::class, 'index']);

// Rota de troca de idioma
$r->addRoute('GET', '/set-language/{lang}', function($vars, $config) {
    $config['translator']->setLanguage($vars['lang']);
    $referer = $_SERVER['HTTP_REFERER'] ?? '/';
    header('Location: ' . $referer);
    exit;
});

// Rotas principais
$r->addRoute('GET', '/', [HomeController::class, 'index']);
$r->addRoute('GET', '/projetos', [ProjectsController::class, 'index']);
$r->addRoute('GET', '/projetos/{slug}', [ProjectsController::class, 'show']);
$r->addRoute('GET', '/contato', [ContactController::class, 'index']);
$r->addRoute('POST', '/contato', [ContactController::class, 'send']);
$r->addRoute('GET', '/sobre', [HomeController::class, 'about']);
