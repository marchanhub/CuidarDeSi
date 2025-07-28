# Projeto Cuidar de Si - Documentação Atualizada

Este documento descreve a estrutura e funcionalidade dos ficheiros do projeto Cuidar de Si após as melhorias implementadas.

## Estrutura do Projeto

```
WEB/
├── index.html              # Página principal do site
├── style.css              # Estilos CSS do site
├── servicos.html          # Página de serviços
├── contacto.php           # Formulário de contato melhorado
├── processar_contato.php  # Processamento do formulário de contato
├── enviar_email.php       # Script de envio de email com anexos
├── config.php             # Configurações centralizadas do sistema
├── main.js                # Validações JavaScript melhoradas
├── .htaccess              # Configurações de segurança e performance
├── uploads/               # Diretório para arquivos enviados
├── logs/                  # Diretório para arquivos de log
├── vendor/                # Dependências do Composer
├── images/                # Imagens do site
├── composer.json          # Configuração do Composer
└── composer.lock          # Versões das dependências
```

## Melhorias Implementadas

### 1. **Validação Melhorada**
- ✅ Validação de email com regex personalizada
- ✅ Validação de telefone com formato português
- ✅ Validação de arquivos (tipo e tamanho)
- ✅ Validação de comprimento de campos
- ✅ Feedback visual em tempo real

### 2. **Segurança Aprimorada**
- ✅ Sanitização de inputs
- ✅ Proteção contra XSS
- ✅ Configurações de segurança no .htaccess
- ✅ Validação de tipos de arquivo
- ✅ Limitação de tamanho de upload

### 3. **Configuração Centralizada**
- ✅ Arquivo `config.php` com todas as configurações
- ✅ Constantes para emails, validações e logs
- ✅ Funções utilitárias centralizadas
- ✅ Configuração de email unificada

### 4. **Interface Melhorada**
- ✅ Feedback visual durante envio
- ✅ Mensagens de erro mais claras
- ✅ Validação em tempo real
- ✅ Indicadores de campos obrigatórios

### 5. **Logs Organizados**
- ✅ Diretório dedicado para logs
- ✅ Logs separados por funcionalidade
- ✅ Timestamps em todos os logs
- ✅ Melhor rastreamento de erros

## Configuração de Email

O sistema está configurado para enviar emails para: **rrss.cerm@gmail.com**

### Configurações Atuais (Mailtrap para testes):
- Host: sandbox.smtp.mailtrap.io
- Porta: 2525
- Username: 0a1ef9ae40fde8
- Password: a9a28241f7e022

### Para Produção:
Altere as configurações no arquivo `config.php`:
```php
define('EMAIL_HOST', 'seu-servidor-smtp.com');
define('EMAIL_PORT', 587);
define('EMAIL_USERNAME', 'seu-email@dominio.com');
define('EMAIL_PASSWORD', 'sua-senha');
```

## Funcionalidades dos Formulários

### 1. **Formulário de Contato**
- Nome completo (2-100 caracteres)
- Email válido
- Telefone (formato português)
- Mensagem (10-1000 caracteres)
- Validação em tempo real
- Feedback visual

### 2. **Formulário de Candidatura**
- Nome completo (2-100 caracteres)
- Email válido
- Telefone (formato português)
- Upload de CV (PDF, DOC, DOCX, máximo 5MB)
- Validação de arquivo
- Anexo automático ao email

## Validações Implementadas

### Frontend (JavaScript)
- ✅ Validação de email com regex
- ✅ Validação de telefone
- ✅ Validação de arquivo (tipo e tamanho)
- ✅ Feedback visual em tempo real
- ✅ Prevenção de envio duplo

### Backend (PHP)
- ✅ Sanitização de inputs
- ✅ Validação de comprimento
- ✅ Validação de formato de email
- ✅ Validação de telefone
- ✅ Validação de arquivo
- ✅ Logs detalhados de erro

## Configurações de Segurança

### .htaccess
- ✅ Proteção de arquivos sensíveis
- ✅ Headers de segurança
- ✅ Limitação de upload
- ✅ Configurações de sessão
- ✅ Compressão e cache

### PHP
- ✅ Sanitização de inputs
- ✅ Validação rigorosa
- ✅ Logs de segurança
- ✅ Timeout de sessão

## Requisitos do Sistema

- PHP 7.4 ou superior
- Extensões PHP necessárias:
  - ctype
  - filter
  - hash
  - fileinfo
  - session
- Servidor web (XAMPP recomendado)
- Composer para gerenciamento de dependências
- Módulos Apache:
  - mod_rewrite
  - mod_expires
  - mod_deflate
  - mod_headers

## Instalação

1. **Clonar/baixar o projeto**
2. **Instalar dependências:**
   ```bash
   composer install
   ```
3. **Configurar permissões:**
   ```bash
   chmod 777 uploads/
   chmod 777 logs/
   ```
4. **Configurar email no `config.php`**
5. **Testar formulários**

## Testes

### Teste de Formulário de Contato:
1. Acesse `contacto.php`
2. Preencha o formulário com dados válidos
3. Verifique se o email chega em `rrss.cerm@gmail.com`

### Teste de Upload de CV:
1. Acesse a seção "Trabalhe Connosco"
2. Preencha o formulário com um CV válido
3. Verifique se o email com anexo chega

## Logs

Os logs estão organizados em `/logs/`:
- `contact_errors.log` - Erros do formulário de contato
- `email_errors.log` - Erros de envio de email

## Suporte

Para problemas ou dúvidas:
- Verifique os logs em `/logs/`
- Teste as configurações de email
- Verifique as permissões dos diretórios
- Consulte a documentação do PHPMailer

## Notas de Segurança

- ✅ Validação de dados implementada
- ✅ Sanitização de inputs
- ✅ Verificação de tipos de arquivo
- ✅ Limitação de tamanho de upload
- ✅ Logs de erro implementados
- ✅ Proteção contra XSS
- ✅ Headers de segurança
- ✅ Configurações de sessão seguras 