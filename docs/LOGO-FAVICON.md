# 🎨 Como Adicionar Logo e Favicon

## 📁 Arquivos Necessários

Coloque seus arquivos de imagem na pasta `public/assets/img/`:

### Logo
- **Arquivo**: `logo.png` ✅ (já existe)
- **Localização**: `public/assets/img/logo.png`
- **Recomendação**: PNG transparente, 200x200px ou similar

### Favicon (múltiplos tamanhos)

Você pode usar um gerador online como [Favicon.io](https://favicon.io/) ou [RealFaviconGenerator](https://realfavicongenerator.net/)

**Arquivos recomendados:**
```
public/assets/img/
├── favicon.ico           (16x16, 32x32, 48x48)
├── favicon-16x16.png     (16x16)
├── favicon-32x32.png     (32x32)
├── apple-touch-icon.png  (180x180 - para iOS)
└── logo.png              ✅ (já existe)
```

## 🔧 Geradores Online de Favicon

### Opção 1: Favicon.io (Mais Simples)
1. Acesse: https://favicon.io/favicon-converter/
2. Upload sua logo
3. Download o pacote ZIP
4. Extraia e copie os arquivos para `public/assets/img/`

### Opção 2: RealFaviconGenerator (Mais Completo)
1. Acesse: https://realfavicongenerator.net/
2. Upload sua logo (idealmente 512x512px)
3. Customize para cada plataforma
4. Download e copie para `public/assets/img/`

## 📝 Arquivos Já Configurados

### Layout Principal
[resources/views/layouts/main.twig](../resources/views/layouts/main.twig) já está configurado com:

```html
<!-- Favicon para navegadores -->
<link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">

<!-- Ícone para iOS (quando salvar na tela inicial) -->
<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png">

<!-- Logo no menu -->
<a href="/" class="logo">
    <img src="/assets/img/logo.png" alt="Nome do Site">
    <span>Nome do Site</span>
</a>
```

## ✅ Checklist

- [x] Logo configurada no menu
- [x] CSS para logo adicionado
- [ ] Adicionar `favicon.ico` em `public/assets/img/`
- [ ] Adicionar `favicon-16x16.png` em `public/assets/img/`
- [ ] Adicionar `favicon-32x32.png` em `public/assets/img/`
- [ ] Adicionar `apple-touch-icon.png` em `public/assets/img/`

## 🎯 Teste Rápido

Depois de adicionar os arquivos:

```bash
# Iniciar servidor
php -S localhost:8000 -t public

# Acessar
http://localhost:8000
```

Verifique:
1. Logo aparece no menu de navegação
2. Favicon aparece na aba do navegador
3. Logo e favicon ficam bem em dispositivos móveis

## 🎨 Dicas de Design

### Para a Logo:
- Use PNG com fundo transparente
- Tamanho recomendado: 200x200px a 500x500px
- Cores que contratem com o menu
- Mantenha simples e legível

### Para o Favicon:
- Deve ser reconhecível mesmo em 16x16px
- Use as cores principais da sua marca
- Evite detalhes muito pequenos
- Teste em diferentes backgrounds (claro/escuro)

## 💡 Opção Rápida com Texto

Se você não tiver uma logo ainda, pode usar apenas texto estilizado:

Remova a imagem do layout e mantenha apenas:
```html
<a href="/" class="logo">
    <span class="logo-text">DJ</span>
</a>
```

E adicione um estilo especial no CSS:
```css
.logo-text {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 900;
    font-size: 2rem;
}
```
