<?php

use FastRoute\RouteCollector;

// Carregar configuração
$config = require_once __DIR__ . '/../bootstrap/app.php';

// Configurar roteamento
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    require __DIR__ . '/../routes/web.php';
});

// Obter método e URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remover query string e decodificar URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Processar idioma da URL
$uri = $config['languageMiddleware']->handle($uri);

// Despachar rota
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo $config['twig']->render('errors/404.twig');
        break;
        
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "Método não permitido";
        break;
        
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        // Executar controller
        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $controllerInstance = new $controller($config);
            echo $controllerInstance->$method($vars);
        } else {
            echo $handler($vars, $config);
        }
        break;
}
