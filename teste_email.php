<?php
/**
 * Script de Teste do Sistema de Email - Cuidar de Si
 * 
 * Este script testa todas as funcionalidades do sistema de email:
 * - Configurações SMTP
 * - Envio de emails
 * - Validações
 * - Logs
 * - Uploads
 */

// Ativar exibição de erros para debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir configurações
require __DIR__ . '/config.php';

// Incluir o autoloader do Composer
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Função para log de teste
function logTest($message, $type = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] [$type] $message\n";
    echo "<div style='margin: 5px 0; padding: 5px; border-left: 3px solid ";
    
    switch ($type) {
        case 'SUCCESS':
            echo "green; background: #d4edda;'>✅ ";
            break;
        case 'ERROR':
            echo "red; background: #f8d7da;'>❌ ";
            break;
        case 'WARNING':
            echo "orange; background: #fff3cd;'>⚠️ ";
            break;
        default:
            echo "blue; background: #d1ecf1;'>ℹ️ ";
    }
    
    echo htmlspecialchars($message) . "</div>";
    
    // Salvar no log
    error_log($logMessage, 3, __DIR__ . '/logs/teste_email.log');
}

// Função para testar configurações
function testConfigurations() {
    logTest("=== TESTE DE CONFIGURAÇÕES ===", 'INFO');
    
    // Verificar se as constantes estão definidas
    $required_constants = [
        'EMAIL_HOST',
        'EMAIL_PORT', 
        'EMAIL_USERNAME',
        'EMAIL_PASSWORD',
        'EMAIL_FROM',
        'EMAIL_FROM_NAME',
        'CONTACT_EMAIL'
    ];
    
    foreach ($required_constants as $constant) {
        if (defined($constant)) {
            $value = constant($constant);
            if (empty($value) && $constant === 'EMAIL_PASSWORD') {
                logTest("$constant: [NÃO CONFIGURADO] - Precisa configurar a senha", 'WARNING');
            } else {
                logTest("$constant: " . (strlen($value) > 20 ? substr($value, 0, 20) . '...' : $value), 'SUCCESS');
            }
        } else {
            logTest("$constant: NÃO DEFINIDA", 'ERROR');
        }
    }
    
    // Verificar se PHPMailer está disponível
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        logTest("PHPMailer: Disponível", 'SUCCESS');
    } else {
        logTest("PHPMailer: NÃO DISPONÍVEL", 'ERROR');
    }
    
    // Verificar permissões de pastas
    $folders = [
        'logs' => __DIR__ . '/logs',
        'uploads' => __DIR__ . '/uploads'
    ];
    
    foreach ($folders as $name => $path) {
        if (file_exists($path)) {
            if (is_writable($path)) {
                logTest("Pasta $name: Existe e tem permissão de escrita", 'SUCCESS');
            } else {
                logTest("Pasta $name: Existe mas SEM permissão de escrita", 'ERROR');
            }
        } else {
            logTest("Pasta $name: NÃO EXISTE", 'ERROR');
        }
    }
}

// Função para testar conexão SMTP
function testSMTPConnection() {
    logTest("=== TESTE DE CONEXÃO SMTP ===", 'INFO');
    
    if (empty(EMAIL_HOST) || empty(EMAIL_USERNAME)) {
        logTest("Configurações SMTP incompletas", 'ERROR');
        return false;
    }
    
    $mail = new PHPMailer(true);
    
    try {
        // Configurações básicas
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->Port = EMAIL_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = 'tls';
        
        // Ativar debug para ver detalhes
        $mail->SMTPDebug = 0; // 0 = sem debug, 2 = debug completo
        
        logTest("Tentando conectar ao servidor SMTP: " . EMAIL_HOST . ":" . EMAIL_PORT, 'INFO');
        
        // Tentar conectar
        $mail->smtpConnect();
        
        logTest("Conexão SMTP bem-sucedida!", 'SUCCESS');
        return true;
        
    } catch (Exception $e) {
        logTest("Erro na conexão SMTP: " . $e->getMessage(), 'ERROR');
        return false;
    }
}

// Função para testar envio de email
function testEmailSending() {
    logTest("=== TESTE DE ENVIO DE EMAIL ===", 'INFO');
    
    if (empty(EMAIL_PASSWORD)) {
        logTest("Senha do email não configurada - pulando teste de envio", 'WARNING');
        return false;
    }
    
    $mail = new PHPMailer(true);
    
    try {
        // Configurações
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->Port = EMAIL_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = 'tls';
        
        // Remetente e destinatário
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME . ' - Teste');
        $mail->addAddress(CONTACT_EMAIL);
        
        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Teste de Email - Cuidar de Si';
        $mail->Body = "
        <html>
        <head>
            <title>Teste de Email</title>
        </head>
        <body>
            <h2>Teste de Email - Cuidar de Si</h2>
            <p>Este é um email de teste para verificar se o sistema está funcionando corretamente.</p>
            <p><strong>Data/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>
            <p><strong>Servidor:</strong> " . EMAIL_HOST . "</p>
            <p><strong>Remetente:</strong> " . EMAIL_FROM . "</p>
            <p><strong>Destinatário:</strong> " . CONTACT_EMAIL . "</p>
            <hr>
            <p><em>Se recebeu este email, o sistema está funcionando corretamente!</em></p>
        </body>
        </html>
        ";
        
        logTest("Enviando email de teste para: " . CONTACT_EMAIL, 'INFO');
        
        $mail->send();
        logTest("Email de teste enviado com sucesso!", 'SUCCESS');
        return true;
        
    } catch (Exception $e) {
        logTest("Erro ao enviar email: " . $e->getMessage(), 'ERROR');
        return false;
    }
}

// Função para testar validações
function testValidations() {
    logTest("=== TESTE DE VALIDAÇÕES ===", 'INFO');
    
    // Teste de validação de email
    $test_emails = [
        'teste@cuidardesi.pt' => true,
        'geral@cuidardesi.pt' => true,
        'email.invalido' => false,
        '@dominio.com' => false,
        'teste@' => false
    ];
    
    foreach ($test_emails as $email => $expected) {
        $result = validateEmail($email);
        if ($result === $expected) {
            logTest("Validação de email '$email': " . ($result ? 'VÁLIDO' : 'INVÁLIDO'), 'SUCCESS');
        } else {
            logTest("Validação de email '$email': FALHOU (esperado: " . ($expected ? 'VÁLIDO' : 'INVÁLIDO') . ")", 'ERROR');
        }
    }
    
    // Teste de validação de telefone
    $test_phones = [
        '223711700' => true,
        '933815041' => true,
        '+351223711700' => true,
        '123' => false,
        'abcdefghij' => false
    ];
    
    foreach ($test_phones as $phone => $expected) {
        $result = validatePhone($phone);
        if ($result === $expected) {
            logTest("Validação de telefone '$phone': " . ($result ? 'VÁLIDO' : 'INVÁLIDO'), 'SUCCESS');
        } else {
            logTest("Validação de telefone '$phone': FALHOU (esperado: " . ($expected ? 'VÁLIDO' : 'INVÁLIDO') . ")", 'ERROR');
        }
    }
}

// Função para testar uploads
function testUploads() {
    logTest("=== TESTE DE UPLOADS ===", 'INFO');
    
    $upload_dir = __DIR__ . '/uploads';
    
    if (!file_exists($upload_dir)) {
        logTest("Pasta uploads não existe", 'ERROR');
        return false;
    }
    
    if (!is_writable($upload_dir)) {
        logTest("Pasta uploads não tem permissão de escrita", 'ERROR');
        return false;
    }
    
    // Criar arquivo de teste
    $test_file = $upload_dir . '/teste_' . uniqid() . '.txt';
    $content = "Arquivo de teste criado em " . date('Y-m-d H:i:s');
    
    if (file_put_contents($test_file, $content)) {
        logTest("Arquivo de teste criado: " . basename($test_file), 'SUCCESS');
        
        // Simular validação de arquivo
        $fake_file = [
            'name' => 'teste.txt',
            'type' => 'text/plain',
            'size' => strlen($content),
            'tmp_name' => $test_file,
            'error' => 0
        ];
        
        if (validateFile($fake_file)) {
            logTest("Validação de arquivo: OK", 'SUCCESS');
        } else {
            logTest("Validação de arquivo: FALHOU", 'ERROR');
        }
        
        // Limpar arquivo de teste
        unlink($test_file);
        logTest("Arquivo de teste removido", 'INFO');
        
    } else {
        logTest("Falha ao criar arquivo de teste", 'ERROR');
    }
}

// Função para gerar relatório
function generateReport($results) {
    logTest("=== RELATÓRIO FINAL ===", 'INFO');
    
    $total_tests = count($results);
    $passed_tests = count(array_filter($results));
    $failed_tests = $total_tests - $passed_tests;
    
    logTest("Total de testes: $total_tests", 'INFO');
    logTest("Testes aprovados: $passed_tests", 'SUCCESS');
    logTest("Testes falharam: $failed_tests", $failed_tests > 0 ? 'ERROR' : 'SUCCESS');
    
    if ($failed_tests === 0) {
        logTest("🎉 TODOS OS TESTES PASSARAM! O sistema está funcionando corretamente.", 'SUCCESS');
    } else {
        logTest("⚠️ Alguns testes falharam. Verifique as configurações.", 'WARNING');
    }
}

// ========================================
// EXECUÇÃO DOS TESTES
// ========================================

echo "<!DOCTYPE html>
<html lang='pt'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste de Email - Cuidar de Si</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #0c727a; text-align: center; border-bottom: 2px solid #0c727a; padding-bottom: 10px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .timestamp { color: #666; font-size: 12px; }
        .btn { background: #0c727a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
        .btn:hover { background: #095a61; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🧪 Teste do Sistema de Email</h1>
        <p class='timestamp'>Executado em: " . date('Y-m-d H:i:s') . "</p>
        <div class='test-section'>";

$results = [];

// Executar testes
$results[] = testConfigurations();
$results[] = testSMTPConnection();
$results[] = testEmailSending();
$results[] = testValidations();
$results[] = testUploads();

echo "</div>";

generateReport($results);

echo "
        <div style='text-align: center; margin-top: 30px;'>
            <button class='btn' onclick='location.reload()'>🔄 Executar Novamente</button>
            <button class='btn' onclick='window.close()'>❌ Fechar</button>
        </div>
    </div>
</body>
</html>";
?> 