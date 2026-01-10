<?php

namespace App\Middleware;

use App\Services\TranslationService;

class LanguageMiddleware
{
    private TranslationService $translator;

    public function __construct(TranslationService $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Processa a requisição e detecta o idioma da URL
     */
    public function handle(string $uri): string
    {
        // Extrai o prefixo de idioma da URI (ex: /en/about -> en)
        $parts = explode('/', trim($uri, '/'));
        
        if (!empty($parts[0]) && in_array($parts[0], $this->translator->getAvailableLanguages())) {
            $language = $parts[0];
            $this->translator->setLanguage($language);
            
            // Remove o prefixo de idioma da URI
            array_shift($parts);
            return '/' . implode('/', $parts);
        }

        return $uri;
    }

    /**
     * Gera URL com prefixo de idioma
     */
    public function url(string $path, ?string $language = null): string
    {
        $lang = $language ?? $this->translator->getCurrentLanguage();
        $path = ltrim($path, '/');
        
        return '/' . $lang . '/' . $path;
    }

    /**
     * Alterna para outro idioma mantendo a rota atual
     */
    public function switchLanguage(string $newLanguage, string $currentPath): string
    {
        // Remove o prefixo de idioma atual se existir
        $parts = explode('/', trim($currentPath, '/'));
        
        if (!empty($parts[0]) && in_array($parts[0], $this->translator->getAvailableLanguages())) {
            array_shift($parts);
        }
        
        $path = implode('/', $parts);
        return $this->url($path, $newLanguage);
    }
}
