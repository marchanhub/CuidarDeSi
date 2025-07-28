# 🧪 Scripts de Teste do Sistema de Email

Este documento explica como usar os scripts de teste para verificar se o sistema de email está funcionando corretamente.

## 📁 Arquivos de Teste

### 1. `teste_rapido.php` - Teste Básico
- **Função:** Verificação rápida das configurações
- **Uso:** Primeiro teste a executar
- **Duração:** ~5 segundos

### 2. `teste_email.php` - Teste Completo
- **Função:** Teste completo de todas as funcionalidades
- **Uso:** Após configurar a senha do email
- **Duração:** ~30 segundos

## 🚀 Como Usar

### Passo 1: Teste Rápido
1. Acesse no navegador: `https://cuidardesi.pt/NewWebSite/teste_rapido.php`
2. Verifique se todas as configurações estão corretas
3. Se a senha não estiver configurada, configure-a primeiro

### Passo 2: Configurar Senha (se necessário)
1. Edite o arquivo `config.php` no cPanel
2. Localize a linha: `define('EMAIL_PASSWORD', '');`
3. Adicione a senha: `define('EMAIL_PASSWORD', 'sua-senha-real');`
4. Salve o arquivo

### Passo 3: Teste Completo
1. Acesse: `https://cuidardesi.pt/NewWebSite/teste_email.php`
2. Aguarde a execução de todos os testes
3. Verifique o relatório final

## 📋 O que os Testes Verificam

### Teste Rápido (`teste_rapido.php`)
- ✅ Configurações básicas (EMAIL_HOST, EMAIL_PORT, etc.)
- ✅ Existência das pastas (logs, uploads, vendor)
- ✅ Disponibilidade do PHPMailer
- ✅ Permissões de escrita

### Teste Completo (`teste_email.php`)
- ✅ **Configurações:** Todas as constantes e dependências
- ✅ **Conexão SMTP:** Teste de conexão com o servidor
- ✅ **Envio de Email:** Teste real de envio (se senha configurada)
- ✅ **Validações:** Teste das funções de validação
- ✅ **Uploads:** Teste de criação e validação de arquivos
- ✅ **Logs:** Geração de logs de teste

## 🎯 Resultados Esperados

### ✅ Sucesso
```
🎉 TODOS OS TESTES PASSARAM! 
O sistema está funcionando corretamente.
```

### ⚠️ Avisos
- Senha não configurada
- Permissões de pasta incorretas
- Alguns testes falharam

### ❌ Erros
- Configurações SMTP incorretas
- PHPMailer não disponível
- Pastas não existem

## 📊 Logs de Teste

Os testes geram logs em:
- `logs/teste_email.log` - Log detalhado do teste completo
- `logs/email_errors.log` - Log de erros do sistema

## 🔧 Solução de Problemas

### Problema: "Senha não configurada"
**Solução:** Edite `config.php` e adicione a senha do email

### Problema: "Conexão SMTP falhou"
**Soluções possíveis:**
1. Verificar se o servidor SMTP está correto
2. Verificar se a porta está correta (587 ou 465)
3. Verificar se as credenciais estão corretas
4. Verificar se o servidor permite conexões SMTP

### Problema: "Pasta não tem permissão de escrita"
**Solução:** No cPanel, alterar permissões da pasta para 755 ou 777

### Problema: "PHPMailer não disponível"
**Solução:** Executar `composer install` na pasta do projeto

## 📞 Suporte

Se os testes falharem, verifique:
1. Os logs em `logs/teste_email.log`
2. As configurações em `config.php`
3. As permissões das pastas
4. A conectividade com o servidor SMTP

## 🗑️ Limpeza

Após confirmar que tudo está funcionando:
1. Remova os arquivos de teste do servidor
2. Mantenha apenas os logs se necessário para debug

---

**Nota:** Estes scripts são apenas para teste. Remova-os do servidor de produção após confirmar que tudo está funcionando. 