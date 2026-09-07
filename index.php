<?php
// 0. Настройка папки logs и логирования ошибок PHP
$logDir = __DIR__ . '/logs';
$logFile = $logDir . '/php_errors.log';

if (!file_exists($logDir)) {
    @mkdir($logDir, 0755, true);
}

// === АВТООЧИСТКА ЛОГА ПРИ ПРЕВЫШЕНИИ 5 МБ ===
if (file_exists($logFile) && filesize($logFile) > 5 * 1024 * 1024) {
    file_put_contents($logFile, ''); 
}
// ============================================

ini_set('log_errors', '1');
ini_set('error_log', $logFile);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

function getClientIP() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $firstIp = trim($ipList[0]);
        if (filter_var($firstIp, FILTER_VALIDATE_IP)) {
            return $firstIp;
        }
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function setLanguageCookie($language) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? 80) == 443;
    setcookie('user_lang', $language, [
        'expires'  => time() + (86400 * 30),
        'path'     => '/',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// 1. Получаем текущий маршрут из адресной строки
$rawRoute = isset($_GET['route']) ? trim($_GET['route'], '/') : '';

// === 1.1. ОПРЕДЕЛЕНИЕ ЯЗЫКА ИЗ URL ИЛИ GET ===
$lang = null;
$clean_route = $rawRoute;

if (preg_match('#^ru(/|$)#i', $rawRoute)) {
    $lang = 'ru';
    $clean_route = trim(preg_replace('#^ru(/|$)#i', '', $rawRoute), '/');
} elseif (preg_match('#^en(/|$)#i', $rawRoute)) {
    $lang = 'en';
    $clean_route = trim(preg_replace('#^en(/|$)#i', '', $rawRoute), '/');
} elseif (preg_match('#^(ua|uk)(/|$)#i', $rawRoute)) {
    // Если явно переходят на /ua или /uk, редиректим на дефолтный URL без префикса
    $clean_route = trim(preg_replace('#^(ua|uk)(/|$)#i', '', $rawRoute), '/');
    setLanguageCookie('uk');
    header("Location: /" . $clean_route, true, 301);
    exit;
} elseif (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ru', 'uk', 'ua'])) {
    $lang = $_GET['lang'] === 'ua' ? 'uk' : $_GET['lang'];
}

// === 1.2. ЕСЛИ ЯЗЫК НЕ УКАЗАН В URL: ПРОВЕРЯЕМ БРАУЗЕР ИЛИ КУКИ ===
if ($lang === null) {
    if (isset($_COOKIE['user_lang'])) {
        // Пользователь уже посещал сайт и перешёл на URL без префикса (например, /postcards) — 
        // устанавливаем украинский язык (дефолтный)
        $lang = 'uk';
    } else {
        // ПЕРВЫЙ ВХОД: определяем язык по браузеру
        $browserLang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2));

        if ($browserLang === 'ru') {
            $lang = 'ru';
        } elseif ($browserLang === 'en') {
            $lang = 'en';
        } else {
            $lang = 'uk';
        }

        // Авто-редирект при самом первом заходе на корень сайта (/)
        if ($rawRoute === '' && !isset($_GET['lang'])) {
            setLanguageCookie($lang);

            if ($lang === 'ru') {
                header("Location: /ru", true, 302);
                exit;
            } elseif ($lang === 'en') {
                header("Location: /en", true, 302);
                exit;
            }
        }
    }
}

// Сохраняем итоговый язык в куки
setLanguageCookie($lang);


// === 1.3. УНИВЕРСАЛЬНЫЙ ПЕРЕХВАТ ДЛЯ QR-КОДОВ И СТАТИСТИКИ (MATOMO) ===
$cleanRawRoute = strtolower(preg_replace('#\.php$#i', '', $rawRoute));

$qrRedirects = [
    '12345' => 'https://emotionsbymail.com/digital?utm_source=qr_code&utm_medium=offline&utm_campaign=campaign_12345',
    'kyiv'  => 'https://emotionsbymail.com/digital?utm_source=qr_code&utm_medium=print&utm_campaign=kyiv_poster',
    'promo' => 'https://emotionsbymail.com/digital?utm_source=flyer&utm_medium=offline&utm_campaign=autumn_promo',
];

if (isset($qrRedirects[$cleanRawRoute])) {
    $targetUrl = $qrRedirects[$cleanRawRoute];

    if ($lang === 'en' && strpos($targetUrl, '/en/') === false) {
        $targetUrl = str_replace('emotionsbymail.com/', 'emotionsbymail.com/en/', $targetUrl);
    } elseif ($lang === 'ru' && strpos($targetUrl, '/ru/') === false) {
        $targetUrl = str_replace('emotionsbymail.com/', 'emotionsbymail.com/ru/', $targetUrl);
    }

    header("Location: " . $targetUrl, true, 302);
    exit;
}
// =====================================================================


// 2. Подключаем массив с переводами интерфейса
$lang_file = __DIR__ . "/lang/{$lang}.php";
if (!file_exists($lang_file) && $lang === 'uk') {
    $lang_file = __DIR__ . "/lang/ua.php";
}

if (file_exists($lang_file)) {
    $texts = include($lang_file);
} else {
    $texts = [];
    $user_ip = getClientIP();
    error_log("Warning: Language file not found: {$lang_file} | IP -> {$user_ip}");
}

// 3. Роутер страниц
switch ($clean_route) {
    case '':
        $page_title = $texts['title_home'] ?? 'Emotions by Mail';
        $template = 'home.php';
        break;
        
    case 'paper':
    case 'paper.php':
        $page_title = $texts['title_paper'] ?? 'Paper Letters';
        $template = 'paper.php';
        break;
        
    case 'digital':
    case 'digital.php':
        $page_title = $texts['title_digital'] ?? 'Digital Support';
        $template = 'digital.php';
        break;

    case 'payment':
    case 'payment.php':
        $page_title = $texts['title_payment'] ?? 'Payment Guide';
        $template = 'payment.php';
        break;

    case 'postcards':
    case 'postcards.php':
        $page_title = $texts['title_postcards'] ?? 'Postcards';
        $template = 'postcards.php';
        break;

    case 'privacy':
    case 'privacy.php':
    case 'privacy-policy':
    case 'privacy-policy.php':
        $page_title = $texts['title_privacy'] ?? 'Privacy Policy';
        $template = 'legal/privacy.php';
        break;

    case 'terms':
    case 'terms.php':
    case 'terms-of-service':
    case 'terms-of-service.php':
        $page_title = $texts['title_terms'] ?? 'Terms & Conditions';
        $template = 'legal/terms.php';
        break;

    case 'refund-policy':
    case 'refund-policy.php':
        $page_title = $texts['title_refund'] ?? 'Refund Policy';
        $template = 'legal/refund-policy.php';
        break;

    case 'shipping-policy':
    case 'shipping-policy.php':
        $page_title = $texts['title_shipping'] ?? 'Shipping Policy';
        $template = 'legal/shipping-policy.php';
        break;
        
    default:
        http_response_code(404);
        
        $user_ip = getClientIP();
        $request_uri = $_SERVER['REQUEST_URI'] ?? $clean_route;
        $http_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown Agent';
        $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

        error_log("404 Not Found: [{$http_method}] URI -> {$request_uri} | IP -> {$user_ip} | Referer -> {$referer} | User-Agent -> {$user_agent}");

        $file_404 = __DIR__ . '/templates/404.php';
        if (file_exists($file_404)) {
            include $file_404;
        } else {
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>404</title></head><body style="font-family:sans-serif;text-align:center;padding-top:100px;"><h1 style="font-size:72px;">404</h1><p>Page not found</p><a href="/" style="color:#000;">Home</a></body></html>';
        }
        exit;
}

// 4. Собираем страницу
include __DIR__ . '/templates/header.php';

if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'test.emotionsbymail.com') {
    echo '<div style="position:fixed;top:10px;right:10px;background:#ff3b30;color:#ffffff;padding:6px 14px;font-size:12px;font-weight:bold;font-family:sans-serif;border-radius:20px;box-shadow:0 4px 12px rgba(255,59,48,0.4);z-index:99999;pointer-events:none;letter-spacing:0.5px;text-transform:uppercase;">🧪 TEST STAGING</div>';
}

include __DIR__ . '/templates/' . $template;
include __DIR__ . '/templates/footer.php';