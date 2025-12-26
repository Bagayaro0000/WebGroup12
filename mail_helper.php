<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv; // 加入這一行

// 1. 修正路徑
require_once __DIR__ . '/vendor/autoload.php';

function sendSystemMail($to, $subject, $content) {

// 2. 載入 .env
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['M365_USER'];
    $mail->Password   = $_ENV['M365_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet = 'UTF-8';

    // 設定寄件人與收件人
    $mail->setFrom($_ENV['M365_USER'], '成果上傳系統通知');
    $mail->addAddress($to); // 寄到你的 Gmail
    
    
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $content;

    $mail->send();
    echo 'Email sent successfully to Gmail!';
} catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
}
}