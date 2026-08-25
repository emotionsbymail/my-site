<?php
// 0. Настройка папки logs и логирования ошибок PHP
$logDir = __DIR__ . '/logs';

if (!file_exists($logDir)) {
    @mkdir($logDir, 0755, true);
}

ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/php_errors.log');
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

// 1. Получаем текущий маршрут из адресной строки и очищаем крайностей слэши
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';

// 2. Определяем язык строго по URL (/en/postcards или /ru/postcards)
$lang = 'uk';
$clean_route = $route;

if (preg_match('#^ru(/|$)#i', $route)) {
    $lang = 'ru';
    $clean_route = trim(preg_replace('#^ru(/|$)#i', '', $route), '/');
} elseif (preg_match('#^en(/|$)#i', $route)) {
    $lang = 'en';
    $clean_route = trim(preg_replace('#^en(/|$)#i', '', $route), '/');
} elseif (preg_match('#^(ua|uk)(/|$)#i', $route)) {
    $clean_route = trim(preg_replace('#^(ua|uk)(/|$)#i', '', $route), '/');
    $redirect_url = '/' . $clean_route;
    header("Location: " . $redirect_url, true, 301);
    exit;
} elseif (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ru', 'uk', 'ua'])) {
    $req_lang = $_GET['lang'] === 'ua' ? 'uk' : $_GET['lang'];
    $lang = $req_lang;
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

// 3. АВТООПРЕДЕЛЕНИЕ: срабатывает при первом заходе на главный корень '/'
if ($route === '' && !isset($_GET['lang']) && !isset($_COOKIE['user_lang'])) {
    $browser_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $primary_lang = strtolower(substr($browser_lang, 0, 2));

    if ($primary_lang === 'ru') {
        setLanguageCookie('ru');
        header("Location: /ru", true, 302);
        exit;
    } elseif ($primary_lang === 'en') {
        setLanguageCookie('en');
        header("Location: /en", true, 302);
        exit;
    } else {
        setLanguageCookie('uk');
    }
} else {
    setLanguageCookie($lang);
}

// 4. Подключаем массив с переводами интерфейса
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

// 5. Обновленный роутер с поддержкой postcards
switch ($clean_route) {
    case '':
        $page_title = $texts['title_home'] ?? 'Emotions by Mail';
        $template = 'home.php';
        break;
        
    case 'paper':
        $page_title = $texts['title_paper'] ?? 'Paper Letters';
        $template = 'paper.php';
        break;
        
    case 'digital':
        $page_title = $texts['title_digital'] ?? 'Digital Support';
        $template = 'digital.php';
        break;

    case 'payment':
        $page_title = $texts['title_payment'] ?? 'Payment Guide';
        $template = 'payment.php';
        break;

    case 'postcards':
        $page_title = $texts['title_postcards'] ?? 'Postcards';
        $template = 'postcards.php';
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

// 6. Собираем стандартную страницу
include __DIR__ . '/templates/header.php';

if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'test.emotionsbymail.com') {
    echo '<div style="position:fixed;top:10px;right:10px;background:#ff3b30;color:#ffffff;padding:6px 14px;font-size:12px;font-weight:bold;font-family:sans-serif;border-radius:20px;box-shadow:0 4px 12px rgba(255,59,48,0.4);z-index:99999;pointer-events:none;letter-spacing:0.5px;text-transform:uppercase;">🧪 TEST STAGING</div>';
}

include __DIR__ . '/templates/' . basename($template);
include __DIR__ . '/templates/footer.php';