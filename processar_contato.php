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
function sendEmail($to, $subject, $message) {
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
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME . ' - Formulário de Contato');
        $mail->addAddress($to);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        logError("Erro ao enviar email: {$mail->ErrorInfo}", CONTACT_LOG_FILE);
        return false;
    }
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e sanitiza os dados do formulário
    $nome = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $telefone = sanitizeInput($_POST['phone'] ?? '');
    $mensagem = sanitizeInput($_POST['message'] ?? '');
    
    // Validação básica
    if (empty($nome) || empty($email) || empty($telefone) || empty($mensagem)) {
        logError("Campos obrigatórios não preenchidos", CONTACT_LOG_FILE);
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
        exit;
    }

    // Validar comprimento do nome
    if (strlen($nome) < MIN_NAME_LENGTH || strlen($nome) > MAX_NAME_LENGTH) {
        logError("Nome com comprimento inválido: " . strlen($nome), CONTACT_LOG_FILE);
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("O nome deve ter entre " . MIN_NAME_LENGTH . " e " . MAX_NAME_LENGTH . " caracteres."));
        exit;
    }

    // Validar email com verificação completa
    $emailValidation = validateEmailComplete($email);
    if (!$emailValidation['valid']) {
        logError("Email inválido: $email - " . $emailValidation['error'], CONTACT_LOG_FILE);
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("Email inválido: " . $emailValidation['error']));
        exit;
    }

    // Validar telefone
    if (!validatePhone($telefone)) {
        logError("Formato de telefone inválido: $telefone", CONTACT_LOG_FILE);
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("Por favor, forneça um número de telefone válido."));
        exit;
    }

    // Validar comprimento da mensagem
    if (strlen($mensagem) < MIN_MESSAGE_LENGTH || strlen($mensagem) > MAX_MESSAGE_LENGTH) {
        logError("Mensagem com comprimento inválido: " . strlen($mensagem), CONTACT_LOG_FILE);
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("A mensagem deve ter entre " . MIN_MESSAGE_LENGTH . " e " . MAX_MESSAGE_LENGTH . " caracteres."));
        exit;
    }

    // Cria o corpo do email
    $message = "
    <html>
    <head>
        <title>Nova Mensagem de Contato</title>
        <link rel='stylesheet' href='estilo.css'>
        <link rel='stylesheet' href='estilo-mobile.css'>
        <style>
            body { font-family: Arial, sans-serif; }
            .info { margin: 10px 0; }
            .label { font-weight: bold; }
            .message { margin-top: 20px; padding: 10px; background-color: #f5f5f5; }
        </style>
    </head>
    <body>
        <h2>Nova Mensagem de Contato Recebida</h2>
        <div class='info'>
            <span class='label'>Nome:</span> $nome
        </div>
        <div class='info'>
            <span class='label'>Email:</span> $email
        </div>
        <div class='info'>
            <span class='label'>Telefone:</span> $telefone
        </div>
        <div class='message'>
            <span class='label'>Mensagem:</span><br>
            " . nl2br(htmlspecialchars($mensagem)) . "
        </div>
    </body>
    </html>
    ";

    // Tenta enviar o email
    if (sendEmail(CONTACT_EMAIL, "Nova Mensagem de Contato - Cuidar de Si", $message)) {
        header("Location: contacto.php?contact_status=success&msg=" . urlencode("Mensagem enviada com sucesso! Entraremos em contato em breve."));
    } else {
        header("Location: contacto.php?contact_status=error&msg=" . urlencode("Erro ao enviar a mensagem. Por favor, tente novamente mais tarde."));
    }
} else {
    header("Location: contacto.php");
}
?> 