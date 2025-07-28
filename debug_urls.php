<?php
/**
 * Debug de URLs - Cuidar de Si
 * 
 * Script simples para verificar se as URLs estão funcionando
 */

echo "<h2>🔍 Debug de URLs</h2>";
echo "<p><strong>URL Atual:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>Script:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<h3>📁 Verificar Arquivos:</h3>";

$files_to_check = [
    'index.html' => 'Página Inicial',
    'servicos.html' => 'Página de Serviços', 
    'contacto.php' => 'Página de Contacto'
];

foreach ($files_to_check as $file => $description) {
    $full_path = __DIR__ . '/' . $file;
    if (file_exists($full_path)) {
        echo "<p style='color: green;'>✅ $file existe ($description)</p>";
    } else {
        echo "<p style='color: red;'>❌ $file NÃO existe ($description)</p>";
    }
}

echo "<h3>🔗 Testar URLs:</h3>";
echo "<p><a href='index' target='_blank'>Testar: index</a></p>";
echo "<p><a href='servicos' target='_blank'>Testar: servicos</a></p>";
echo "<p><a href='contacto' target='_blank'>Testar: contacto</a></p>";

echo "<h3>🔗 Testar URLs com extensão:</h3>";
echo "<p><a href='index.html' target='_blank'>Testar: index.html</a></p>";
echo "<p><a href='servicos.html' target='_blank'>Testar: servicos.html</a></p>";
echo "<p><a href='contacto.php' target='_blank'>Testar: contacto.php</a></p>";

echo "<h3>📊 Informações do Servidor:</h3>";
echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Diretório Atual:</strong> " . __DIR__ . "</p>";

// Verificar se .htaccess existe
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "<p style='color: green;'>✅ Arquivo .htaccess existe</p>";
} else {
    echo "<p style='color: red;'>❌ Arquivo .htaccess NÃO existe</p>";
}
?> 