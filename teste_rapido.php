<?php
/**
 * Teste Rápido do Sistema de Email
 * 
 * Script simples para verificar se as configurações básicas estão corretas
 */

// Ativar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>🧪 Teste Rápido - Sistema de Email</h2>";
echo "<p><strong>Data/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Verificar se o arquivo de configuração existe
if (!file_exists(__DIR__ . '/config.php')) {
    echo "<p style='color: red;'>❌ Arquivo config.php não encontrado!</p>";
    exit;
}

// Incluir configurações
require __DIR__ . '/config.php';

echo "<h3>📋 Verificação de Configurações:</h3>";

// Verificar constantes
$configs = [
    'EMAIL_HOST' => EMAIL_HOST ?? 'NÃO DEFINIDO',
    'EMAIL_PORT' => EMAIL_PORT ?? 'NÃO DEFINIDO',
    'EMAIL_FROM' => EMAIL_FROM ?? 'NÃO DEFINIDO',
    'EMAIL_FROM_NAME' => EMAIL_FROM_NAME ?? 'NÃO DEFINIDO',
    'CONTACT_EMAIL' => CONTACT_EMAIL ?? 'NÃO DEFINIDO'
];

foreach ($configs as $key => $value) {
    $color = ($value === 'NÃO DEFINIDO' || $value === 'NÃO CONFIGURADO') ? 'red' : 'green';
    $icon = ($value === 'NÃO DEFINIDO' || $value === 'NÃO CONFIGURADO') ? '❌' : '✅';
    echo "<p style='color: $color;'>$icon <strong>$key:</strong> $value</p>";
}

echo "<h3>📁 Verificação de Pastas:</h3>";

// Verificar pastas
$folders = [
    'logs' => __DIR__ . '/logs',
    'uploads' => __DIR__ . '/uploads',
    'vendor' => __DIR__ . '/vendor'
];

foreach ($folders as $name => $path) {
    if (file_exists($path)) {
        if (is_writable($path)) {
            echo "<p style='color: green;'>✅ Pasta $name: Existe e tem permissão de escrita</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Pasta $name: Existe mas SEM permissão de escrita</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Pasta $name: NÃO EXISTE</p>";
    }
}

echo "<h3>📧 Verificação PHPMailer:</h3>";

// Verificar PHPMailer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
    
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        echo "<p style='color: green;'>✅ PHPMailer: Disponível</p>";
    } else {
        echo "<p style='color: red;'>❌ PHPMailer: NÃO DISPONÍVEL</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Autoloader do Composer não encontrado</p>";
}

echo "<h3>🔧 Próximos Passos:</h3>";

if (file_exists(__DIR__ . '/vendor/autoload.php') && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "<p style='color: green;'>✅ Sistema de email configurado corretamente!</p>";
    echo "<p><a href='teste_email.php' style='background: #0c727a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🧪 Executar Teste Completo</a></p>";
} else {
    echo "<p style='color: orange;'>⚠️ <strong>Ação Necessária:</strong> Verificar instalação do PHPMailer</p>";
    echo "<p>Execute 'composer install' na pasta do projeto.</p>";
}

echo "<h3>📧 Teste de Validação de Email:</h3>";

// Testar validação de email
$test_emails = [
    'teste@cuidardesi.pt' => 'Email válido',
    'geral@cuidardesi.pt' => 'Email válido',
    'teste@gmail.com' => 'Email válido',
    'email.invalido' => 'Formato inválido',
    '@dominio.com' => 'Formato inválido',
    'teste@dominioinexistente123456.com' => 'Domínio inexistente'
];

foreach ($test_emails as $email => $expected) {
    $result = validateEmailComplete($email);
    $status = $result['valid'] ? '✅' : '❌';
    $color = $result['valid'] ? 'green' : 'red';
    echo "<p style='color: $color;'>$status <strong>$email:</strong> " . ($result['valid'] ? 'VÁLIDO' : $result['error']) . "</p>";
}

echo "<hr>";
echo "<p><small>Para mais detalhes, execute o <a href='teste_email.php'>teste completo</a>.</small></p>";
?> 