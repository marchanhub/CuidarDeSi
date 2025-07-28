<?php
/**
 * Teste de URLs Limpas
 * 
 * Script para verificar se as URLs sem extensão estão funcionando
 */

// Ativar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>
<html lang='pt'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste de URLs Limpas - Cuidar de Si</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #0c727a; text-align: center; border-bottom: 2px solid #0c727a; padding-bottom: 10px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        .btn { background: #0c727a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; text-decoration: none; display: inline-block; }
        .btn:hover { background: #095a61; }
        .url-test { margin: 10px 0; padding: 10px; border-left: 3px solid #ddd; }
        .url-test.success { border-left-color: green; background: #d4edda; }
        .url-test.error { border-left-color: red; background: #f8d7da; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔗 Teste de URLs Limpas</h1>
        <p><strong>Data/Hora:</strong> " . date('Y-m-d H:i:s') . "</p>
        <p><strong>URL Atual:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

// Teste 1: Verificar se o .htaccess está funcionando
echo "<div class='test-section'>
    <h3>🔧 Teste 1: Configuração .htaccess</h3>";

if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p class='success'>✅ mod_rewrite está ativo</p>";
    } else {
        echo "<p class='error'>❌ mod_rewrite não está ativo</p>";
    }
} else {
    echo "<p class='info'>ℹ️ Não foi possível verificar mod_rewrite (pode estar funcionando)</p>";
}

// Verificar se o arquivo .htaccess existe
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<p class='success'>✅ Arquivo .htaccess existe</p>";
} else {
    echo "<p class='error'>❌ Arquivo .htaccess não encontrado</p>";
}

echo "</div>";

// Teste 2: URLs para testar
echo "<div class='test-section'>
    <h3>🌐 Teste 2: URLs para Testar</h3>
    <p class='info'>Clique nos links abaixo para testar se as URLs limpas estão funcionando:</p>";

$urls_to_test = [
    'index' => 'Página Inicial',
    'servicos' => 'Página de Serviços',
    'contacto' => 'Página de Contacto'
];

foreach ($urls_to_test as $url => $description) {
    $full_url = 'https://cuidardesi.pt/NewWebSite/' . $url;
    echo "<div class='url-test'>
        <p><strong>$description:</strong></p>
        <p><a href='$url' class='btn' target='_blank'>Testar: $url</a></p>
        <p><small>URL completa: <code>$full_url</code></small></p>
    </div>";
}

echo "</div>";

// Teste 3: Verificar redirecionamentos
echo "<div class='test-section'>
    <h3>🔄 Teste 3: Redirecionamentos</h3>
    <p class='info'>Estas URLs devem redirecionar automaticamente para as versões sem extensão:</p>";

$redirect_urls = [
    'index.html' => 'index',
    'servicos.html' => 'servicos',
    'contacto.php' => 'contacto'
];

foreach ($redirect_urls as $old_url => $new_url) {
    echo "<div class='url-test'>
        <p><strong>Redirecionamento:</strong></p>
        <p><a href='$old_url' class='btn' target='_blank'>Testar: $old_url → $new_url</a></p>
    </div>";
}

echo "</div>";

// Teste 4: Informações do servidor
echo "<div class='test-section'>
    <h3>📊 Informações do Servidor</h3>";

echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

echo "</div>";

echo "
        <div style='text-align: center; margin-top: 30px;'>
            <a href='index' class='btn'>🏠 Ir para Home</a>
            <a href='servicos' class='btn'>🩺 Ir para Serviços</a>
            <a href='contacto' class='btn'>📧 Ir para Contacto</a>
        </div>
    </div>
</body>
</html>";
?> 