<?php
header('Content-Type: application/json; charset=utf-8');

// ---------------------------------------------------
// 1. ПОДКЛЮЧЕНИЕ КОНФИГУРАЦИИ
// ---------------------------------------------------
$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) {
    // Если файла нет в api/, ищем в корне
    $configPath = __DIR__ . '/../config.php';
}

if (!file_exists($configPath)) {
    echo json_encode(['status' => 'error', 'message' => 'Configuration file not found']);
    exit;
}

$config = require $configPath;

// ---------------------------------------------------
// 2. ПОДКЛЮЧЕНИЕ PHPMAILER
// ---------------------------------------------------
$phpMailerDir = __DIR__ . '/PHPMailer';
if (!file_exists($phpMailerDir . '/PHPMailer.php')) {
    // Если папки нет в api/, ищем в корне сайта
    $phpMailerDir = __DIR__ . '/../PHPMailer';
}

if (file_exists($phpMailerDir . '/PHPMailer.php')) {
    require_once $phpMailerDir . '/Exception.php';
    require_once $phpMailerDir . '/PHPMailer.php';
    require_once $phpMailerDir . '/SMTP.php';
} else {
    echo json_encode(['status' => 'error', 'message' => 'PHPMailer library not found']);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ===================================================
// НАСТРОЙКИ ИЗ CONFIG.PHP
// ===================================================
$botToken  = $config['telegram']['bot_token'] ?? ''; 
$chatId    = $config['telegram']['chat_id'] ?? '';

$smtpHost  = $config['smtp']['host'] ?? ''; 
$smtpUser  = $config['smtp']['user'] ?? '';
$smtpPass  = $config['smtp']['pass'] ?? '';
$smtpPort  = $config['smtp']['port'] ?? 465;
$fromEmail = $config['smtp']['from_email'] ?? '';
$replyTo   = $config['smtp']['reply_to'] ?? 'noreply@emotionsbymail.com';

$filePath  = $config['app']['subscribers_file'] ?? (__DIR__ . '/subscribers.txt');
// ===================================================

function getGeoLocation($ip) {
    if ($ip === '127.0.0.1' || $ip === '::1' || empty($ip)) {
        return 'Localhost';
    }

    $url = "http://ip-api.com/json/{$ip}?fields=status,country,city&lang=en";
    
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 2
        ]
    ]);

    $response = @file_get_contents($url, false, $ctx);

    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['status']) && $data['status'] === 'success') {
            $country = $data['country'] ?? 'Unknown Country';
            $city = $data['city'] ?? 'Unknown City';
            return "{$country}, {$city}";
        }
    }

    return 'Unknown Location';
}

$json = file_get_contents('php://input');
$data = json_decode($json, true) ?? [];

// ---------------------------------------------------
// ЗАЩИТА 1: Honeypot-ловушка для ботов
// ---------------------------------------------------
if (!empty($data['b_website']) || !empty($data['phone_hp'])) {
    echo json_encode(['status' => 'success']);
    exit;
}

// ---------------------------------------------------
// ЗАЩИТА 2: Проверка скорости отправки (Time-Based)
// ---------------------------------------------------
if (isset($data['form_time']) && is_numeric($data['form_time'])) {
    $currentTime = time();
    $loadTime = intval($data['form_time']);
    if (($currentTime - $loadTime) < 2) {
        echo json_encode(['status' => 'success']);
        exit;
    }
}

$email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$rawLang = strtolower(trim($data['lang'] ?? 'ru'));
$lang = substr($rawLang, 0, 2);

if (!in_array($lang, ['ru', 'en', 'uk'])) {
    $lang = 'ru';
}

if ($email) {
    $email = strtolower($email);
}

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
    exit;
}

// ---------------------------------------------------
// ЗАЩИТА 3: Проверка реального почтового домена (MX-записи)
// ---------------------------------------------------
$domain = substr(strrchr($email, "@"), 1);
if (!empty($domain) && function_exists('checkdnsrr')) {
    if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email domain']);
        exit;
    }
}

// Проверяем наличие email в базе
$alreadySubscribed = false;
if (file_exists($filePath)) {
    $fileContent = file_get_contents($filePath);
    if (strpos($fileContent, " | " . $email . " | ") !== false) {
        $alreadySubscribed = true;
    }
}

if ($alreadySubscribed) {
    echo json_encode(['status' => 'subscribed']);
    exit;
}

// Получаем реальный IP и локацию
$userIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$userLocation = getGeoLocation($userIp);

// 1. Сохраняем в файл
$log = date('Y-m-d H:i:s') . " | " . $email . " | " . strtoupper($lang) . " | " . $userLocation . " (" . $userIp . ")" . PHP_EOL;
file_put_contents($filePath, $log, FILE_APPEND | LOCK_EX);

// 2. Уведомление в Telegram
if (!empty($botToken) && !empty($chatId)) {
    $message = "🎉 <b>Новая подписка на открытие сайта!</b>\n";
    $message .= "📧 Email: " . $email . "\n";
    $message .= "🌐 Язык: " . strtoupper($lang) . "\n";
    $message .= "📍 Локация: " . $userLocation . "\n";
    $message .= "🖥 IP: " . $userIp;

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.telegram.org/bot{$botToken}/sendMessage",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT => 5
    ]);
    curl_exec($ch);
    curl_close($ch);
}

// 3. Формируем простое текстовое письмо в зависимости от языка
if ($lang === 'en') {
    $fromName = "Emotions by Mail | Tactile Warmth";
    $subject  = "✨ Subscription confirmed! | Emotions by Mail";
    $bodyText = "Hello!\n\n"
              . "Thank you for your interest in our service. We believe real paper letters create a special personal connection that digital screens simply cannot match.\n\n"
              . "We are finalizing everything to make sending physical letters effortless and enjoyable for you.\n\n"
              . "Your Launch Bonus:\n"
              . "We have saved your email. On launch day, you will receive a personal promo code for a special discount on your first order!\n\n"
              . "We will notify you on launch day.\n\n"
              . "Always by your side,\n"
              . "The \"Tactile Warmth\" Team\n"
              . "Emotions by Mail Emotional Support Service\n\n"
              . "--- \n"
              . "⚠️ This is an automated system message, please do not reply directly.";

} elseif ($lang === 'uk') {
    $fromName = "Тактильне тепло | Emotions by Mail";
    $subject  = "✨ Підписку підтверджено! | Emotions by Mail";
    $bodyText = "Вітаємо!\n\n"
              . "Дякуємо за інтерес до нашого сервісу. Ми віримо, що справжні паперові листи створюють особливий зв’язок та дарують емоції, які неможливо передати через екран.\n\n"
              . "Зараз ми завершуємо останні приготування, щоб надсилання паперових листів стало для вас простим, зручним та натхненним ритуалом.\n\n"
              . "Ваш бонус до відкриття:\n"
              . "Ми зберегли ваш email. У день офіційного старту ви отримаєте персональний промокод на спеціальну знижку до вашого першого замовлення!\n\n"
              . "Ми обов’язково напишемо вам у день запуску.\n\n"
              . "Ми завжди поруч,\n"
              . "Команда проєкту «Тактильне тепло»\n"
              . "Сервіс емоційної підтримки Emotions by Mail\n\n"
              . "--- \n"
              . "⚠️ Це автоматичне повідомлення, будь ласка, не відповідайте на нього.";

} else { // 'ru'
    $fromName = "Emotions by Mail | Тактильное тепло";
    $subject  = "✨ Подписка подтверждена! | Emotions by Mail";
    $bodyText = "Здравствуйте!\n\n"
              . "Спасибо за интерес к нашему сервису. Мы верим, что настоящие бумажные письма создают особую связь и дарят эмоции, которые невозможно передать через экран.\n\n"
              . "Сейчас мы завершаем последние приготовления, чтобы отправка физических писем стала для вас простой, удобной и вдохновляющей.\n\n"
              . "Ваш бонус к открытию:\n"
              . "Мы сохранили ваш email. В день официального старта вы получите персональный промокод на специальную скидку к вашему первому заказу!\n\n"
              . "Мы обязательно напишем вам в день запуска.\n\n"
              . "Мы всегда рядом,\n"
              . "Команда проекта «Тактильное тепло»\n"
              . "Сервис эмоциональной поддержки Emotions by Mail\n\n"
              . "--- \n"
              . "⚠️ Это автоматическое сообщение, пожалуйста, не отвечайте на него.";
}

// 4. Отправка простого письма через PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    
    if ((int)$smtpPort === 465) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    }
    
    $mail->Port       = (int)$smtpPort;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($email);

    $mail->addReplyTo($replyTo, 'No Reply');

    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body    = $bodyText;

    $mail->send();
} catch (Exception $e) {
    error_log("PHPMailer Error: {$mail->ErrorInfo}");
}

echo json_encode(['status' => 'success']);
exit;