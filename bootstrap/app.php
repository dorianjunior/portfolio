<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar Twig
$loader = new FilesystemLoader(__DIR__ . '/../resources/views');
$twig = new Environment($loader, [
    'cache' => $_ENV['APP_ENV'] === 'production' ? __DIR__ . '/../storage/cache' : false,
    'debug' => $_ENV['APP_ENV'] === 'development',
]);

return [
    'twig' => $twig,
    'env' => $_ENV
];
