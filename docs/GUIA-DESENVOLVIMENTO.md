# 📚 Guia de Desenvolvimento - Portfólio

## 🎯 Visão Geral do Projeto

Seu portfólio usa uma arquitetura MVC simples:
- **FastRoute**: Sistema de roteamento (URLs → Controllers)
- **Twig**: Engine de templates (Views)
- **PHP 8+**: Backend
- **Bootstrap**: Framework CSS (a ser adicionado)

---

## 🚀 Como Funciona o FastRoute

### Conceito Básico
FastRoute mapeia URLs para funções/métodos PHP.

### Exemplo Prático

**1. Definir rota em** [routes/web.php](routes/web.php):
```php
// Rota simples
$r->addRoute('GET', '/sobre', [HomeController::class, 'about']);

// Rota com parâmetro dinâmico
$r->addRoute('GET', '/projetos/{slug}', [ProjectsController::class, 'show']);

// Rota com múltiplos parâmetros
$r->addRoute('GET', '/blog/{categoria}/{slug}', [BlogController::class, 'show']);
```

**2. Criar método no Controller:**
```php
// app/Controllers/ProjectsController.php
public function show(array $vars): string
{
    $slug = $vars['slug']; // Pega o parâmetro da URL
    $project = Project::findBySlug($slug);
    
    return $this->render('project-detail.twig', [
        'project' => $project
    ]);
}
```

**3. Fluxo completo:**
```
URL digitada: dorian.kesug.com/projetos/sistema-ecommerce
      ↓
FastRoute identifica: GET /projetos/{slug}
      ↓
Extrai parâmetros: $vars = ['slug' => 'sistema-ecommerce']
      ↓
Chama: ProjectsController->show($vars)
      ↓
Renderiza: project-detail.twig
```

### Tipos de Rotas

```php
// GET - buscar dados
$r->addRoute('GET', '/blog', [BlogController::class, 'index']);

// POST - enviar dados
$r->addRoute('POST', '/contato', [ContactController::class, 'send']);

// Aceita múltiplos métodos
$r->addRoute(['GET', 'POST'], '/form', [FormController::class, 'handle']);
```

---

## 🎨 Como Funciona o Twig

### Conceito Básico
Twig é uma engine de templates que separa lógica (PHP) de apresentação (HTML).

### Estrutura de Templates

**1. Layout Base** ([layouts/main.twig](resources/views/layouts/main.twig)):
```twig
<!DOCTYPE html>
<html>
<head>
    <title>{{ title }} - {{ app_name }}</title>
</head>
<body>
    <nav>...</nav>
    
    {% block content %}
        {# Conteúdo da página será injetado aqui #}
    {% endblock %}
    
    <footer>...</footer>
</body>
</html>
```

**2. Página Específica** (home.twig):
```twig
{% extends "layouts/main.twig" %}

{% block content %}
    <h1>{{ title }}</h1>
    <p>Bem-vindo ao meu portfólio!</p>
{% endblock %}
```

### Sintaxe Essencial do Twig

#### Variáveis
```twig
{# Imprimir variável #}
{{ variavel }}
{{ usuario.nome }}
{{ projeto.title }}

{# Com filtros #}
{{ texto|upper }}              {# TEXTO #}
{{ data|date("d/m/Y") }}       {# 09/01/2026 #}
{{ descricao|slice(0, 100) }}  {# Primeiros 100 caracteres #}
```

#### Condicionais
```twig
{% if projeto.githubUrl %}
    <a href="{{ projeto.githubUrl }}">Ver no GitHub</a>
{% elseif projeto.liveUrl %}
    <a href="{{ projeto.liveUrl }}">Ver Demo</a>
{% else %}
    <p>Projeto privado</p>
{% endif %}
```

#### Loops
```twig
{% for projeto in projetos %}
    <div class="card">
        <h3>{{ projeto.title }}</h3>
        <p>{{ projeto.description }}</p>
    </div>
{% else %}
    <p>Nenhum projeto encontrado</p>
{% endfor %}
```

#### Comentários
```twig
{# Isso é um comentário - não aparece no HTML #}
```

### Exemplo Completo

**Controller:**
```php
// app/Controllers/BlogController.php
public function index(): string
{
    $posts = [
        ['title' => 'Post 1', 'views' => 100, 'published' => true],
        ['title' => 'Post 2', 'views' => 50, 'published' => false],
    ];
    
    return $this->render('blog.twig', [
        'title' => 'Blog',
        'posts' => $posts,
        'total' => count($posts)
    ]);
}
```

**View (blog.twig):**
```twig
{% extends "layouts/main.twig" %}

{% block content %}
    <h1>Blog ({{ total }} posts)</h1>
    
    {% for post in posts %}
        {% if post.published %}
            <article>
                <h2>{{ post.title }}</h2>
                <span>{{ post.views }} visualizações</span>
            </article>
        {% endif %}
    {% endfor %}
{% endblock %}
```

---

## 🎨 Adicionando Bootstrap e Bibliotecas JS

### Método 1: Via CDN (Recomendado para Início)

Edite [layouts/main.twig](resources/views/layouts/main.twig):

```twig
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title }} - {{ app_name }}</title>
    
    {# Bootstrap CSS #}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {# Font Awesome Icons #}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {# Seu CSS customizado #}
    <link rel="stylesheet" href="/assets/css/style.css">
    
    {% block styles %}{% endblock %}
</head>
<body>
    {# ... conteúdo ... #}
    
    {# Bootstrap JS + Popper #}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {# jQuery (opcional) #}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    {# Seu JS customizado #}
    <script src="/assets/js/script.js"></script>
    
    {% block scripts %}{% endblock %}
</body>
```

### Método 2: Download Local

```bash
# Baixar Bootstrap
cd public/assets
mkdir libs
cd libs
curl -O https://github.com/twbs/bootstrap/releases/download/v5.3.0/bootstrap-5.3.0-dist.zip
unzip bootstrap-5.3.0-dist.zip
```

Depois incluir:
```twig
<link rel="stylesheet" href="/assets/libs/bootstrap-5.3.0-dist/css/bootstrap.min.css">
```

### Bibliotecas Úteis para Portfólio

```twig
<head>
    {# Bootstrap - Framework CSS #}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {# AOS - Animações ao Scroll #}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    {# Typed.js - Efeito de digitação (opcional) #}
    
    {# Font Awesome - Ícones #}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    {# JavaScript no final do body #}
    
    {# Bootstrap Bundle (inclui Popper) #}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {# AOS - Inicializar animações #}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    
    {# Typed.js - Efeito de digitação #}
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    
    {# Particles.js - Efeito de partículas no fundo (opcional) #}
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
</body>
```

---

## 🔄 Fluxo de Desenvolvimento

### 1. Adicionar Nova Página

**Passo 1: Criar Rota**
```php
// routes/web.php
$r->addRoute('GET', '/curriculo', [HomeController::class, 'resume']);
```

**Passo 2: Criar Método no Controller**
```php
// app/Controllers/HomeController.php
public function resume(): string
{
    return $this->render('resume.twig', [
        'title' => 'Currículo',
        'experiences' => [...],
        'skills' => [...]
    ]);
}
```

**Passo 3: Criar View**
```twig
{# resources/views/resume.twig #}
{% extends "layouts/main.twig" %}

{% block content %}
    <div class="container">
        <h1>{{ title }}</h1>
        {# Seu conteúdo aqui #}
    </div>
{% endblock %}
```

### 2. Adicionar Formulário com Validação

**Controller:**
```php
public function contato(): string
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        
        // Validar
        if (empty($nome)) {
            return $this->render('contato.twig', [
                'erro' => 'Nome obrigatório'
            ]);
        }
        
        // Processar e redirecionar
        // ...
    }
    
    return $this->render('contato.twig');
}
```

### 3. Trabalhar com Assets (CSS/JS)

**Estrutura recomendada:**
```
public/assets/
├── css/
│   ├── style.css        {# Seu CSS principal #}
│   └── components.css   {# Componentes #}
├── js/
│   ├── script.js        {# JS principal #}
│   └── animations.js    {# Animações #}
└── img/
    └── projects/        {# Imagens dos projetos #}
```

**No template:**
```twig
{# CSS específico da página #}
{% block styles %}
    <link rel="stylesheet" href="/assets/css/components.css">
{% endblock %}

{# JS específico da página #}
{% block scripts %}
    <script src="/assets/js/animations.js"></script>
{% endblock %}
```

---

## 🛠️ Comandos Úteis

### Desenvolvimento Local
```bash
# Servidor PHP embutido
php -S localhost:8000 -t public

# Acessar
http://localhost:8000
```

### Testar Rotas
```bash
# Home
curl http://localhost:8000/

# Projetos
curl http://localhost:8000/projetos

# Projeto específico
curl http://localhost:8000/projetos/sistema-ecommerce
```

---

## 📝 Dicas e Boas Práticas

### Controllers
- **Mantenha simples**: Controller busca dados, passa para view
- **Não coloque HTML**: Isso vai no Twig
- **Reutilize**: Use o Controller base para métodos comuns

### Views (Twig)
- **Use extends**: Evite duplicar header/footer
- **Crie blocks**: Para conteúdo específico de cada página
- **Organize**: Agrupe views relacionadas em pastas

### Rotas
- **URLs amigáveis**: Use `/projetos` em vez de `/projetos.php`
- **RESTful**: GET para buscar, POST para enviar
- **Parâmetros**: Use `{parametro}` para valores dinâmicos

### Performance
- **Cache Twig**: Ative em produção
- **Minifique**: CSS/JS em produção
- **CDN**: Use para bibliotecas populares

---

## 📚 Recursos de Aprendizado

### FastRoute
- Documentação: https://github.com/nikic/FastRoute
- Tutorial: https://route.thephpleague.com/5.x/

### Twig
- Documentação oficial: https://twig.symfony.com/doc/
- Tags: https://twig.symfony.com/doc/3.x/tags/index.html
- Filtros: https://twig.symfony.com/doc/3.x/filters/index.html

### Bootstrap
- Documentação: https://getbootstrap.com/docs/5.3/
- Exemplos: https://getbootstrap.com/docs/5.3/examples/
- Components: https://getbootstrap.com/docs/5.3/components/

---

## 🎯 Próximos Passos Recomendados

1. ✅ **Adicionar Bootstrap ao layout** (veja exemplo acima)
2. ✅ **Criar página de exemplo** com componentes Bootstrap
3. ✅ **Personalizar CSS** em `/assets/css/style.css`
4. ✅ **Adicionar animações** com AOS
5. ✅ **Testar responsividade** em diferentes dispositivos
6. ✅ **Adicionar seus projetos reais** em `app/Models/Project.php`
7. ✅ **Fazer deploy** no InfinityFree

---

## 💡 Exemplo Rápido: Criar uma Nova Seção

Vamos criar uma seção "Habilidades" com Bootstrap:

**1. Rota (já existe):**
```php
$r->addRoute('GET', '/', [HomeController::class, 'index']);
```

**2. Controller (já existe):**
```php
// HomeController já retorna skills
```

**3. View atualizada com Bootstrap:**
```twig
{% extends "layouts/main.twig" %}

{% block content %}
<div class="container my-5">
    <h2 class="text-center mb-4">Minhas Habilidades</h2>
    
    <div class="row">
        {% for skill, level in skills %}
        <div class="col-md-6 mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span>{{ skill }}</span>
                <span>{{ level }}%</span>
            </div>
            <div class="progress">
                <div class="progress-bar bg-primary" 
                     role="progressbar" 
                     style="width: {{ level }}%"
                     aria-valuenow="{{ level }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
        </div>
        {% endfor %}
    </div>
</div>
{% endblock %}
```

Pronto! Você tem uma página com Bootstrap funcionando! 🎉
