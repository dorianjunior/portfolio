<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use App\Services\TranslationService;
use App\Middleware\LanguageMiddleware;

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Inicializar serviço de tradução
$translator = new TranslationService(__DIR__ . '/../resources/lang');
$languageMiddleware = new LanguageMiddleware($translator);

// Configurar Twig
$loader = new FilesystemLoader(__DIR__ . '/../resources/views');
$twig = new Environment($loader, [
    'cache' => $_ENV['APP_ENV'] === 'production' ? __DIR__ . '/../storage/cache' : false,
    'debug' => $_ENV['APP_ENV'] === 'development',
]);

// Adicionar função de tradução ao Twig
$twig->addFunction(new TwigFunction('trans', function (string $key, array $replace = []) use ($translator) {
    return $translator->get($key, $replace);
}));

// Adicionar função de URL com idioma ao Twig
$twig->addFunction(new TwigFunction('route', function (string $path, ?string $language = null) use ($languageMiddleware) {
    return $languageMiddleware->url($path, $language);
}));

// Adicionar variáveis globais ao Twig
$twig->addGlobal('current_language', $translator->getCurrentLanguage());
$twig->addGlobal('available_languages', $translator->getAvailableLanguages());
$twig->addGlobal('app_name', $_ENV['APP_NAME'] ?? 'Portfolio');

// Adicionar função para trocar idioma mantendo a rota atual
$twig->addFunction(new TwigFunction('switch_language', function (string $newLang) use ($languageMiddleware) {
    $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
    // Remove query string
    if (false !== $pos = strpos($currentPath, '?')) {
        $currentPath = substr($currentPath, 0, $pos);
    }
    return $languageMiddleware->switchLanguage($newLang, $currentPath);
}));

return [
    'twig' => $twig,
    'env' => $_ENV,
    'translator' => $translator,
    'languageMiddleware' => $languageMiddleware
];
