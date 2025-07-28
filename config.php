<?php
/**
 * Configurações do Sistema Cuidar de Si
 * 
 * Este arquivo contém todas as configurações principais do sistema
 */

// Configurações de Email
// Configuração SMTP sem autenticação (se possível)
define('EMAIL_HOST', 'localhost'); // Servidor local
define('EMAIL_PORT', 25); // Porta padrão sem autenticação
define('EMAIL_FROM', 'geral@cuidardesi.pt');
define('EMAIL_FROM_NAME', 'Cuidar de Si');

// Email de destino para formulários
define('CONTACT_EMAIL', 'geral@cuidardesi.pt');

// Configurações de Upload
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_ALLOWED_TYPES', [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

// Configurações de Log
define('LOG_DIR', __DIR__ . '/logs/');
define('CONTACT_LOG_FILE', __DIR__ . '/logs/contact_errors.log');
define('EMAIL_LOG_FILE', __DIR__ . '/logs/email_errors.log');

// Configurações de Segurança
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_TIMEOUT', 3600); // 1 hora

// Configurações de Validação
define('MIN_NAME_LENGTH', 2);
define('MAX_NAME_LENGTH', 100);
define('MIN_MESSAGE_LENGTH', 10);
define('MAX_MESSAGE_LENGTH', 1000);

// Função para log de erros
function logError($message, $logFile = null) {
    if (!$logFile) {
        $logFile = EMAIL_LOG_FILE;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    error_log($logMessage, 3, $logFile);
}

// Função para validar email (formato)
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Função para verificar se o email existe
function verifyEmailExists($email) {
    // Primeiro validar o formato
    if (!validateEmail($email)) {
        return false;
    }
    
    // Extrair domínio do email
    $domain = substr(strrchr($email, "@"), 1);
    
    // Verificar se o domínio tem registros MX
    if (!checkdnsrr($domain, 'MX')) {
        return false;
    }
    
    // Verificar se o domínio tem registros A
    if (!checkdnsrr($domain, 'A')) {
        return false;
    }
    
    return true;
}

// Função para validar email com verificação completa
function validateEmailComplete($email) {
    // Verificar formato
    if (!validateEmail($email)) {
        return ['valid' => false, 'error' => 'Formato de email inválido'];
    }
    
    // Verificar se o domínio existe
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
        return ['valid' => false, 'error' => 'Domínio de email não existe'];
    }
    
    return ['valid' => true, 'error' => null];
}

// Função para validar telefone
function validatePhone($phone) {
    return preg_match('/^[0-9+\s\-\(\)]{9,15}$/', $phone);
}

// Função para validar arquivo
function validateFile($file) {
    if (!$file || $file['error'] !== 0) {
        return false;
    }
    
    // Verificar tamanho
    if ($file['size'] > UPLOAD_MAX_SIZE) {
        return false;
    }
    
    // Verificar tipo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    return in_array($mimeType, UPLOAD_ALLOWED_TYPES);
}

// Função para sanitizar input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Função para gerar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION[CSRF_TOKEN_NAME];
}

// Função para verificar token CSRF
function verifyCSRFToken($token) {
    if (!isset($_SESSION)) {
        session_start();
    }
    
    return isset($_SESSION[CSRF_TOKEN_NAME]) && 
           hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}
?> 