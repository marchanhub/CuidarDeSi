<?php
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

// Função para enviar email usando PHPMailer sem autenticação
function sendEmail($to, $subject, $message, $attachmentPath = null) {
    $mail = new PHPMailer(true);

    try {
        // Configurações SMTP sem autenticação
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->Port = EMAIL_PORT;
        $mail->SMTPAuth = false; // Sem autenticação
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = false; // Sem SSL/TLS

        // Remetente e destinatário
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
        $mail->addAddress($to);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Anexo (se houver)
        if ($attachmentPath && file_exists($attachmentPath)) {
            $mail->addAttachment($attachmentPath);
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        logError("Erro ao enviar email: {$mail->ErrorInfo}", EMAIL_LOG_FILE);
        return false;
    }
}

// Função para criar e verificar o diretório de uploads
function prepareUploadDirectory() {
    $upload_dir = __DIR__ . '/uploads';
    
    if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            logError("Falha ao criar diretório: $upload_dir");
            return [false, "Não foi possível criar o diretório de uploads."];
        }
        chmod($upload_dir, 0777);
    }
    
    if (!is_writable($upload_dir)) {
        logError("Diretório não tem permissão de escrita: $upload_dir");
        return [false, "O diretório de uploads não tem permissão de escrita."];
    }
    
    return [true, $upload_dir . DIRECTORY_SEPARATOR];
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $nome = sanitizeInput($_POST['nome'] ?? '');
    $telefone = sanitizeInput($_POST['telefone'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    
    // Validação básica
    if (empty($nome) || empty($telefone) || empty($email)) {
        logError("Campos obrigatórios não preenchidos", EMAIL_LOG_FILE);
        header("Location: contacto.php?status=error&msg=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit;
    }

    // Validar comprimento do nome
    if (strlen($nome) < MIN_NAME_LENGTH || strlen($nome) > MAX_NAME_LENGTH) {
        logError("Nome com comprimento inválido: " . strlen($nome), EMAIL_LOG_FILE);
        header("Location: contacto.php?status=error&msg=" . urlencode("O nome deve ter entre " . MIN_NAME_LENGTH . " e " . MAX_NAME_LENGTH . " caracteres."));
        exit;
    }

    // Validar email com verificação completa
    $emailValidation = validateEmailComplete($email);
    if (!$emailValidation['valid']) {
        logError("Email inválido: $email - " . $emailValidation['error'], EMAIL_LOG_FILE);
        header("Location: contacto.php?status=error&msg=" . urlencode("Email inválido: " . $emailValidation['error']));
        exit;
    }

    // Validar telefone
    if (!validatePhone($telefone)) {
        logError("Formato de telefone inválido: $telefone", EMAIL_LOG_FILE);
        header("Location: contacto.php?status=error&msg=" . urlencode("Por favor, forneça um número de telefone válido."));
        exit;
    }

    // Processamento do arquivo do currículo
    $curriculo = $_FILES['curriculo'] ?? null;
    $curriculo_path = '';
    $curriculo_name = '';

    if ($curriculo && $curriculo['error'] == 0) {
        list($success, $result) = prepareUploadDirectory();
        if (!$success) {
            logError("Erro no diretório de uploads: $result");
            header("Location: contacto.php?status=error&msg=" . urlencode($result));
            exit;
        }
        $upload_dir = $result;
        
        // Validar arquivo usando função centralizada
        if (!validateFile($curriculo)) {
            logError("Arquivo inválido: " . $curriculo['name'], EMAIL_LOG_FILE);
            header("Location: contacto.php?status=error&msg=" . urlencode("Arquivo inválido. Use apenas PDF, DOC ou DOCX com máximo 5MB."));
            exit;
        }

        // Gerar nome único para o arquivo
        $curriculo_name = uniqid() . '_' . basename($curriculo['name']);
        $curriculo_path = $upload_dir . $curriculo_name;

        // Tentar fazer o upload
        if (!move_uploaded_file($curriculo['tmp_name'], $curriculo_path)) {
            $error = error_get_last();
            $error_msg = $error ? $error['message'] : "Erro desconhecido";
            logError("Erro no upload: $error_msg");
            header("Location: contacto.php?status=error&msg=" . urlencode("Erro ao fazer upload do arquivo: " . $error_msg));
            exit;
        }
    }

    // Cria o corpo do email
    $message = "
    <html>
    <head>
        <title>Nova Candidatura</title>
        <link rel='stylesheet' href='estilo.css'>
        <link rel='stylesheet' href='estilo-mobile.css'>
        <style>
            body { font-family: Arial, sans-serif; }
            .info { margin: 10px 0; }
            .label { font-weight: bold; }
        </style>
    </head>
    <body>
        <h2>Nova Candidatura Recebida</h2>
        <div class='info'>
            <span class='label'>Nome:</span> $nome
        </div>
        <div class='info'>
            <span class='label'>Telefone:</span> $telefone
        </div>
        <div class='info'>
            <span class='label'>Email:</span> $email
        </div>
    </body>
    </html>
    ";

    // Tenta enviar o email
    $mail_sent = sendEmail(CONTACT_EMAIL, "Nova Candidatura - Cuidar de Si", $message, $curriculo_path);
    
    if ($mail_sent) {
        // Limpar arquivo temporário após envio bem-sucedido
        if (!empty($curriculo_path) && file_exists($curriculo_path)) {
            @unlink($curriculo_path);
        }
        header("Location: contacto.php?status=success");
    } else {
        header("Location: contacto.php?status=error&msg=" . urlencode("Erro ao enviar o email. Por favor, tente novamente mais tarde."));
    }
} else {
    header("Location: contacto.php");
}
?> 