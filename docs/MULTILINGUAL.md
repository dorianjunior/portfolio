# Sistema Multilíngue - Guia de Uso

## 📋 Visão Geral

Seu portfólio agora suporta **3 idiomas**: Português (pt), Inglês (en) e Espanhol (es).

## 🚀 Funcionalidades Implementadas

### 1. **Serviço de Tradução** (`TranslationService`)
- Detecta automaticamente o idioma do navegador
- Armazena preferência em cookie (30 dias)
- Gerencia todos os arquivos de tradução

### 2. **Middleware de Idioma** (`LanguageMiddleware`)
- Processa URLs com prefixo de idioma (ex: `/en/projetos`)
- Gera URLs automaticamente com idioma
- Permite troca fácil entre idiomas

### 3. **Arquivos de Tradução**
Localizados em `resources/lang/`:
- `pt.json` - Português (Brasil)
- `en.json` - Inglês
- `es.json` - Espanhol

### 4. **Interface Visual**
- Seletor de idioma no navbar com bandeiras
- Dropdown elegante com transições
- Destaque do idioma ativo

## 📖 Como Usar

### No PHP (Controllers):

```php
// Obter tradução
$texto = $this->trans('home.title');

// Com substituições
$texto = $this->trans('welcome.message', ['name' => 'João']);
```

### Nas Views (Twig):

```twig
{# Tradução simples #}
{{ trans('nav.home') }}

{# Gerar URL com idioma #}
<a href="{{ route('projetos') }}">{{ trans('nav.projects') }}</a>

{# Idioma atual #}
{{ current_language }}

{# Lista de idiomas disponíveis #}
{% for lang in available_languages %}
    {{ lang }}
{% endfor %}
```

### No JavaScript:

O seletor de idioma funciona automaticamente. Ao clicar em um idioma:
1. Cookie é atualizado
2. Sessão é salva
3. Página recarrega com novo idioma

## 🔧 Estrutura dos Arquivos de Tradução

```json
{
  "nav": {
    "home": "Início",
    "projects": "Projetos",
    "about": "Sobre",
    "contact": "Contato"
  },
  "home": {
    "title": "Início",
    "welcome": "Olá, eu sou",
    "role": "Desenvolvedor Full Stack"
  }
}
```

### Acessar traduções aninhadas:
```php
$this->trans('nav.home')          // "Início"
$this->trans('home.welcome')      // "Olá, eu sou"
```

## 📝 Adicionar Novas Traduções

1. Edite os 3 arquivos em `resources/lang/`
2. Adicione a mesma chave em todos os idiomas:

**pt.json:**
```json
{
  "minha_secao": {
    "titulo": "Meu Título"
  }
}
```

**en.json:**
```json
{
  "minha_secao": {
    "titulo": "My Title"
  }
}
```

**es.json:**
```json
{
  "minha_secao": {
    "titulo": "Mi Título"
  }
}
```

3. Use na view:
```twig
{{ trans('minha_secao.titulo') }}
```

## 🌐 Como Funciona a Detecção de Idioma

**Ordem de prioridade:**
1. Cookie `language` (se existir)
2. Sessão PHP `$_SESSION['language']`
3. Header `Accept-Language` do navegador
4. Idioma padrão: Português (pt)

## 🎨 Seletor de Idioma

O seletor está no navbar e exibe:
- Bandeira do país
- Nome do idioma
- Dropdown ao clicar
- Destaque do idioma ativo

### CSS Classes:
- `.language-selector` - Container
- `.language-btn` - Botão principal
- `.language-dropdown` - Menu dropdown
- `.language-option` - Item de idioma
- `.language-option.active` - Idioma selecionado

## 🔗 URLs com Idioma

### Modo Manual (opcional):
Você pode adicionar prefixo de idioma nas URLs:
- `/pt/projetos` - Projetos em português
- `/en/projects` - Projetos em inglês
- `/es/proyectos` - Projetos em espanhol

### Modo Automático (atual):
O sistema detecta automaticamente e não usa prefixo na URL. A preferência fica salva no cookie/sessão.

## 🛠️ Personalização

### Adicionar novo idioma:

1. **Criar arquivo de tradução:**
```bash
resources/lang/fr.json  # Francês
```

2. **Atualizar TranslationService:**
```php
private array $availableLanguages = ['pt', 'en', 'es', 'fr'];
```

3. **Adicionar no layout:**
```twig
{% if lang == 'fr' %}🇫🇷{% endif %}
```

## ✅ Checklist de Implementação

- [x] Serviço de tradução (TranslationService)
- [x] Middleware de idioma (LanguageMiddleware)
- [x] Arquivos de tradução (pt, en, es)
- [x] Integração com Twig
- [x] Atualização de controllers
- [x] Atualização de views
- [x] Seletor visual de idioma
- [x] Estilos CSS responsivos
- [x] JavaScript para interação

## 🎯 Próximos Passos Recomendados

1. **Traduzir conteúdo dinâmico** (projetos do banco de dados)
2. **SEO multilíngue** (meta tags hreflang)
3. **URLs amigáveis** por idioma (ex: `/en/about`)
4. **Persistência** no banco de dados
5. **Admin panel** para gerenciar traduções

## 📞 Suporte

O sistema está pronto para uso! Todas as páginas principais estão traduzidas:
- Home
- Projetos
- Sobre
- Contato
- Erros 404

Basta acessar seu portfólio e testar o seletor de idioma no canto superior direito!
