<?php
/**
 * Exemplo de Configurações de Email para Diferentes Provedores
 * 
 * Copie as configurações desejadas para o arquivo config.php
 */

// ========================================
// CONFIGURAÇÃO PARA GMAIL
// ========================================
/*
define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_PORT', 587);
define('EMAIL_USERNAME', 'seu-email@gmail.com');
define('EMAIL_PASSWORD', 'sua-senha-de-app'); // Use senha de app, não a senha normal
define('EMAIL_FROM', 'geral@cuidardesi.pt');
define('EMAIL_FROM_NAME', 'Cuidar de Si');
*/

// ========================================
// CONFIGURAÇÃO PARA OUTLOOK/HOTMAIL
// ========================================
/*
define('EMAIL_HOST', 'smtp-mail.outlook.com');
define('EMAIL_PORT', 587);
define('EMAIL_USERNAME', 'seu-email@outlook.com');
define('EMAIL_PASSWORD', 'sua-senha');
define('EMAIL_FROM', 'geral@cuidardesi.pt');
define('EMAIL_FROM_NAME', 'Cuidar de Si');
*/

// ========================================
// CONFIGURAÇÃO PARA SERVIDOR PRÓPRIO (cPanel)
// ========================================
/*
define('EMAIL_HOST', 'mail.cuidardesi.pt');
define('EMAIL_PORT', 587); // ou 465 para SSL
define('EMAIL_USERNAME', 'geral@cuidardesi.pt');
define('EMAIL_PASSWORD', 'sua-senha');
define('EMAIL_FROM', 'geral@cuidardesi.pt');
define('EMAIL_FROM_NAME', 'Cuidar de Si');
*/

// ========================================
// CONFIGURAÇÃO PARA C-PANEL (RECOMENDADO)
// ========================================
/*
define('EMAIL_HOST', 'mail.cuidardesi.pt');
define('EMAIL_PORT', 587);
define('EMAIL_USERNAME', 'geral@cuidardesi.pt');
define('EMAIL_PASSWORD', 'sua-senha');
define('EMAIL_FROM', 'geral@cuidardesi.pt');
define('EMAIL_FROM_NAME', 'Cuidar de Si');
*/

// ========================================
// INSTRUÇÕES IMPORTANTES
// ========================================

/*
1. GMAIL:
   - Ative a verificação em 2 passos
   - Gere uma "senha de app" em: https://myaccount.google.com/apppasswords
   - Use essa senha de app, não sua senha normal

2. OUTLOOK/HOTMAIL:
   - Pode precisar ativar "apps menos seguros" ou usar senha de app

3. SERVIDOR PRÓPRIO:
   - Verifique com seu provedor de hospedagem as configurações SMTP
   - Geralmente usa a porta 587 (TLS) ou 465 (SSL)

4. TESTE:
   - Sempre teste o envio antes de colocar em produção
   - Verifique os logs em /logs/email_errors.log
*/
?> 