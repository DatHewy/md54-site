<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['success' => false]);
    exit;
}

$to = "masterdomstroy54@mail.ru";

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

$subject = "Новая заявка с сайта от " . $name;

$body = "=== НОВАЯ ЗАЯВКА С САЙТА ===\n\n";
$body .= "Имя клиента: $name\n";
$body .= "Телефон: $phone\n";
$body .= "E-mail: " . ($email ? $email : 'не указан') . "\n\n";
$body .= "Описание проекта:\n$message\n\n";
$body .= "---\n";
$body .= "Дата: " . date('d.m.Y H:i:s') . "\n";
$body .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n";

$headers = "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
if ($email) {
    $headers .= "Reply-To: $email\r\n";
}
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
