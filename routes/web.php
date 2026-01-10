<?php

use App\Controllers\HomeController;
use App\Controllers\ProjectsController;
use App\Controllers\ContactController;
use FastRoute\RouteCollector;

/** @var RouteCollector $r */

// Rota principal - Home
$r->addRoute('GET', '/', [HomeController::class, 'index']);

// Rotas de Projetos
$r->addRoute('GET', '/projetos', [ProjectsController::class, 'index']);
$r->addRoute('GET', '/projetos/{slug}', [ProjectsController::class, 'show']);

// Rotas de Contato
$r->addRoute('GET', '/contato', [ContactController::class, 'index']);
$r->addRoute('POST', '/contato', [ContactController::class, 'send']);

// Rota sobre mim 
$r->addRoute('GET', '/sobre', [HomeController::class, 'about']);
