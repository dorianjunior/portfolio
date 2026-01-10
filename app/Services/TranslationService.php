<?php

namespace App\Services;

class TranslationService
{
    private array $translations = [];
    private string $currentLanguage;
    private string $fallbackLanguage = 'pt';
    private array $availableLanguages = ['pt', 'en', 'es'];
    private string $langPath;

    public function __construct(string $langPath)
    {
        $this->langPath = $langPath;
        $this->currentLanguage = $this->detectLanguage();
        $this->loadTranslations($this->currentLanguage);
    }

    /**
     * Detecta o idioma preferido do usuário
     */
    private function detectLanguage(): string
    {
        // 1. Verifica cookie
        if (isset($_COOKIE['language']) && $this->isValidLanguage($_COOKIE['language'])) {
            return $_COOKIE['language'];
        }

        // 2. Verifica sessão
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['language']) && $this->isValidLanguage($_SESSION['language'])) {
            return $_SESSION['language'];
        }

        // 3. Verifica Accept-Language do navegador
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if ($this->isValidLanguage($browserLang)) {
                return $browserLang;
            }
        }

        // 4. Retorna idioma padrão
        return $this->fallbackLanguage;
    }

    /**
     * Carrega traduções de um idioma
     */
    private function loadTranslations(string $language): void
    {
        $filePath = $this->langPath . '/' . $language . '.json';
        
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $this->translations = json_decode($content, true) ?? [];
        } else {
            // Carrega idioma de fallback
            $fallbackPath = $this->langPath . '/' . $this->fallbackLanguage . '.json';
            if (file_exists($fallbackPath)) {
                $content = file_get_contents($fallbackPath);
                $this->translations = json_decode($content, true) ?? [];
            }
        }
    }

    /**
     * Obtém uma tradução
     */
    public function get(string $key, array $replace = []): string
    {
        $keys = explode('.', $key);
        $value = $this->translations;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $key; // Retorna a chave se não encontrar tradução
            }
            $value = $value[$k];
        }

        // Substitui placeholders
        foreach ($replace as $search => $replacement) {
            $value = str_replace(':' . $search, $replacement, $value);
        }

        return $value;
    }

    /**
     * Define o idioma atual
     */
    public function setLanguage(string $language): void
    {
        if ($this->isValidLanguage($language)) {
            $this->currentLanguage = $language;
            $this->loadTranslations($language);
            
            // Salva no cookie (30 dias)
            setcookie('language', $language, time() + (30 * 24 * 60 * 60), '/');
            
            // Salva na sessão
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['language'] = $language;
        }
    }

    /**
     * Obtém o idioma atual
     */
    public function getCurrentLanguage(): string
    {
        return $this->currentLanguage;
    }

    /**
     * Obtém todos os idiomas disponíveis
     */
    public function getAvailableLanguages(): array
    {
        return $this->availableLanguages;
    }

    /**
     * Verifica se um idioma é válido
     */
    private function isValidLanguage(string $language): bool
    {
        return in_array($language, $this->availableLanguages);
    }

    /**
     * Obtém o nome do idioma
     */
    public function getLanguageName(string $code): string
    {
        $names = [
            'pt' => 'Português',
            'en' => 'English',
            'es' => 'Español'
        ];

        return $names[$code] ?? $code;
    }

    /**
     * Obtém a flag do idioma
     */
    public function getLanguageFlag(string $code): string
    {
        $flags = [
            'pt' => '🇧🇷',
            'en' => '🇺🇸',
            'es' => '🇪🇸'
        ];

        return $flags[$code] ?? '🌐';
    }
}
