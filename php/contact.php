<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$company = trim($_POST['company'] ?? '');
$message = trim($_POST['message'] ?? '');

if (
    empty($name) ||
    empty($email) ||
    empty($message)
) {
    http_response_code(400);
    exit('Please fill all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Invalid email address.');
}

try {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USER'];
    $mail->Password = $_ENV['SMTP_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->setFrom($_ENV['SMTP_USER'], 'Portfolio Contact Form');

    $mail->addReplyTo($email, $name);

    $mail->addAddress($_ENV['CONTACT_EMAIL']);

    $mail->Subject = 'New Portfolio Contact Form Submission';

    $body = "
        <h2>New Contact Form Submission</h2>

        <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>

        <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>

        <p><strong>Company:</strong> " . htmlspecialchars($company) . "</p>

        <p><strong>Message:</strong><br>" .
        nl2br(htmlspecialchars($message)) .
        "</p>
    ";

    $mail->isHTML(true);
    $mail->Body = $body;

    $mail->send();

    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully.'
    ]);

    header('Location: ../contact.html');

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Failed to send message.'
    ]);
}