<?php
/**
 * Teste de Validação de Email
 * 
 * Script para testar as funções de validação de email
 */

// Ativar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir configurações
require __DIR__ . '/config.php';

echo "<!DOCTYPE html>
<html lang='pt'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste de Validação de Email - Cuidar de Si</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #0c727a; text-align: center; border-bottom: 2px solid #0c727a; padding-bottom: 10px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        .btn { background: #0c727a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
        .btn:hover { background: #095a61; }
        .email-test { margin: 10px 0; padding: 10px; border-left: 3px solid #ddd; }
        .email-test.valid { border-left-color: green; background: #d4edda; }
        .email-test.invalid { border-left-color: red; background: #f8d7da; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📧 Teste de Validação de Email</h1>
        <p><strong>Data/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>";

// Teste 1: Validação de Formato
echo "<div class='test-section'>
    <h3>🔍 Teste 1: Validação de Formato</h3>";

$format_tests = [
    'teste@cuidardesi.pt' => true,
    'geral@cuidardesi.pt' => true,
    'teste@gmail.com' => true,
    'teste@outlook.com' => true,
    'email.invalido' => false,
    '@dominio.com' => false,
    'teste@' => false,
    'teste' => false,
    'teste@.com' => false,
    'teste@dominio.' => false
];

foreach ($format_tests as $email => $expected) {
    $result = validateEmail($email);
    $status = ($result === $expected) ? '✅' : '❌';
    $color = ($result === $expected) ? 'success' : 'error';
    $valid_text = $result ? 'VÁLIDO' : 'INVÁLIDO';
    echo "<p class='$color'>$status <strong>$email:</strong> $valid_text</p>";
}

echo "</div>";

// Teste 2: Verificação de Existência de Domínio
echo "<div class='test-section'>
    <h3>🌐 Teste 2: Verificação de Domínio</h3>";

$domain_tests = [
    'teste@cuidardesi.pt' => 'Domínio real',
    'teste@gmail.com' => 'Domínio real',
    'teste@outlook.com' => 'Domínio real',
    'teste@dominioinexistente123456.com' => 'Domínio inexistente',
    'teste@dominiofalso.xyz' => 'Domínio inexistente'
];

foreach ($domain_tests as $email => $description) {
    $result = verifyEmailExists($email);
    $status = $result ? '✅' : '❌';
    $color = $result ? 'success' : 'error';
    $valid_text = $result ? 'DOMÍNIO EXISTE' : 'DOMÍNIO NÃO EXISTE';
    echo "<p class='$color'>$status <strong>$email</strong> ($description): $valid_text</p>";
}

echo "</div>";

// Teste 3: Validação Completa
echo "<div class='test-section'>
    <h3>🎯 Teste 3: Validação Completa</h3>";

$complete_tests = [
    'teste@cuidardesi.pt' => 'Email válido',
    'geral@cuidardesi.pt' => 'Email válido',
    'teste@gmail.com' => 'Email válido',
    'teste@outlook.com' => 'Email válido',
    'email.invalido' => 'Formato inválido',
    '@dominio.com' => 'Formato inválido',
    'teste@dominioinexistente123456.com' => 'Domínio inexistente',
    'teste@' => 'Formato inválido',
    'teste@.com' => 'Formato inválido'
];

foreach ($complete_tests as $email => $expected) {
    $result = validateEmailComplete($email);
    $status = $result['valid'] ? '✅' : '❌';
    $color = $result['valid'] ? 'success' : 'error';
    $message = $result['valid'] ? 'VÁLIDO' : $result['error'];
    echo "<div class='email-test " . ($result['valid'] ? 'valid' : 'invalid') . "'>
        <p class='$color'>$status <strong>$email</strong> ($expected): $message</p>
    </div>";
}

echo "</div>";

// Teste 4: Performance
echo "<div class='test-section'>
    <h3>⚡ Teste 4: Performance</h3>";

$start_time = microtime(true);
for ($i = 0; $i < 100; $i++) {
    validateEmailComplete('teste@cuidardesi.pt');
}
$end_time = microtime(true);
$execution_time = ($end_time - $start_time) * 1000; // em milissegundos

echo "<p class='info'>⏱️ Tempo para 100 validações: " . number_format($execution_time, 2) . " ms</p>";
echo "<p class='info'>⏱️ Tempo médio por validação: " . number_format($execution_time / 100, 4) . " ms</p>";

echo "</div>";

// Resumo
echo "<div class='test-section'>
    <h3>📊 Resumo</h3>
    <p class='info'>✅ <strong>Validação de Formato:</strong> Verifica se o email tem formato válido</p>
    <p class='info'>✅ <strong>Verificação de Domínio:</strong> Verifica se o domínio existe (MX/A records)</p>
    <p class='info'>✅ <strong>Validação Completa:</strong> Combina formato + domínio</p>
    <p class='info'>⚠️ <strong>Limitação:</strong> Não verifica se a caixa de email específica existe</p>
    <p class='info'>💡 <strong>Nota:</strong> Para verificação completa seria necessário enviar um email de teste</p>
</div>";

echo "
        <div style='text-align: center; margin-top: 30px;'>
            <button class='btn' onclick='location.reload()'>🔄 Executar Novamente</button>
            <button class='btn' onclick='window.close()'>❌ Fechar</button>
        </div>
    </div>
</body>
</html>";
?> 