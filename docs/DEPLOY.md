# Guia de Deploy - InfinityFree

## 📋 Informações do Servidor

- **Domínio**: dorian.kesug.com
- **PHP**: 8.3.27
- **Document Root**: /home/vol1_3/infinityfree.com/if0_40676794/htdocs
- **Painel Admin**: https://dash.infinityfree.com/accounts/if0_40676794

## 🗄️ Banco de Dados MySQL

```
Host: sql204.infinityfree.com
Usuário: if0_40676794
Senha: tm6Pvl5ssv
Database: if0_40676794_db_dorian (recomendado para o portfólio)
```

## 🚀 Passos para Deploy

### 1. Preparar Arquivos Localmente

```bash
# Instalar dependências
composer install --no-dev --optimize-autoloader

# Criar arquivo .env de produção
cp .env.production .env
```

### 2. Upload via FTP

**Credenciais FTP** (obter no painel InfinityFree):
- Host: ftpupload.net (ou conforme painel)
- Usuário: if0_40676794
- Porta: 21

**Estrutura no servidor:**
```
htdocs/
├── .htaccess          (redireciona para public/)
├── .env              (copiar de .env.production e ajustar)
├── composer.json
├── app/
├── bootstrap/
├── resources/
├── routes/
├── vendor/           (upload completo)
└── public/
    ├── .htaccess
    ├── index.php
    └── assets/
```

### 3. Configurar Arquivo .env no Servidor

Edite o `.env` no servidor com suas configurações reais:
- Coloque suas credenciais de email para o formulário de contato
- Confirme APP_ENV=production
- Confirme APP_URL=https://dorian.kesug.com

### 4. Criar Pastas Necessárias

Via File Manager do InfinityFree, crie:
```
htdocs/storage/logs/
htdocs/storage/cache/
```

Defina permissões 755 para essas pastas.

### 5. Testar o Site

Acesse: https://dorian.kesug.com

**URLs disponíveis:**
- https://dorian.kesug.com/ (Home)
- https://dorian.kesug.com/projetos (Projetos)
- https://dorian.kesug.com/sobre (Sobre)
- https://dorian.kesug.com/contato (Contato)

## ⚠️ Limitações do InfinityFree

1. **Email**: A função mail() pode não funcionar. Considere:
   - Usar API de email (SendGrid, Mailgun)
   - Formulário que salva em banco
   - Integração com serviços externos

2. **Sessões**: Podem ter limitações
3. **Recursos**: CPU e RAM limitados (otimize o código)

## 🔧 Troubleshooting

### Erro 500
- Verifique logs no painel de controle
- Confirme permissões das pastas
- Verifique se .htaccess está correto

### CSS/JS não carregam
- Confirme que assets/ está em public/
- Verifique permissões (644 para arquivos)

### Rotas não funcionam
- Confirme que mod_rewrite está ativo
- Verifique ambos .htaccess (raiz e public/)

## 📧 Email no Formulário de Contato

Como mail() pode não funcionar, o sistema salva emails em:
`storage/logs/emails.log`

Você pode verificar mensagens recebidas lá ou implementar uma alternativa.

## ✅ Checklist Final

- [ ] Upload de todos os arquivos
- [ ] Configurar .env com dados corretos
- [ ] Criar pastas storage/logs e storage/cache
- [ ] Testar todas as páginas
- [ ] Verificar se assets carregam
- [ ] Testar formulário de contato
- [ ] Verificar responsividade mobile
