<?php
// 0. Настройка папки logs и логирования ошибок PHP
$logDir = __DIR__ . '/logs';

// Автоматически создаем папку logs, если она не существует
if (!file_exists($logDir)) {
    @mkdir($logDir, 0755, true);
}

// Включаем запись всех ошибок в файл logs/php_errors.log
ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/php_errors.log');

// Вспомогательная функция для получения реального IP-адреса посетителя
function getClientIP() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP']; // Заголовок Cloudflare
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


// 1. Получаем текущий маршрут из адресной строки
$route = isset($_GET['route']) ? rtrim($_GET['route'], '/') : '';

// 2. Определяем язык строго по URL (структура /en/ или /ru/ или GET-параметрам ?lang=en)
$lang = 'uk'; // Стандартный язык по умолчанию (Украинский)
$clean_route = $route;

if (preg_match('/^ru(\/|$)/', $route)) {
    $lang = 'ru';
    $clean_route = preg_replace('/^ru(\/|$)/', '', $route);
} elseif (preg_match('/^en(\/|$)/', $route)) {
    $lang = 'en';
    $clean_route = preg_replace('/^en(\/|$)/', '', $route);
} elseif (preg_match('/^(ua|uk)(\/|$)/', $route)) {
    // Если пользователь перешел по ссылке с /ua/ или /uk/, перенаправляем на чистый URL без префикса (каноничный UA)
    $clean_route = preg_replace('/^(ua|uk)(\/|$)/', '', $route);
    $redirect_url = '/' . $clean_route;
    header("Location: " . $redirect_url, true, 301);
    exit;
} elseif (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ru', 'uk', 'ua'])) {
    // Поддержка ?lang=en или ?lang=ru в адресной строке
    $req_lang = $_GET['lang'] === 'ua' ? 'uk' : $_GET['lang'];
    $lang = $req_lang;
}

// Вспомогательная функция для безопасной установки куки языка
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

// 3. АВТООПРЕДЕЛЕНИЕ: Срабатывает ТОЛЬКО при самом первом заходе на чистый корень '/' и БЕЗ сохраненной куки
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
    // 4. Запоминаем выбранный язык страницы в Cookie
    setLanguageCookie($lang);
}

// 5. Подключаем массив с переводами интерфейса
$lang_file = __DIR__ . "/lang/{$lang}.php";
if (!file_exists($lang_file) && $lang === 'uk') {
    $lang_file = __DIR__ . "/lang/ua.php";
}

if (file_exists($lang_file)) {
    $texts = include($lang_file);
} else {
    $texts = [];
    // Логируем предупреждение, если файл языкового перевода не найден
    error_log("Warning: Language file not found: {$lang_file}");
}

// 6. Простейший роутер
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
        
    default:
        // Отдаем чистую страницу 404 без подключения header.php и footer.php
        http_response_code(404);
        
        // Получаем реальный IP-адрес клиента
        $user_ip = getClientIP();
        $request_uri = $_SERVER['REQUEST_URI'] ?? $clean_route;

        // Логируем попытки захода на несуществующие страницы с записью IP
        error_log("404 Not Found: IP -> {$user_ip} | URI -> {$request_uri}");

        $file_404 = __DIR__ . '/templates/404.php';
        if (file_exists($file_404)) {
            include $file_404;
        } else {
            // Резервный вывод, если самого файла 404.php нет в папке templates
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>404</title></head><body style="font-family:sans-serif;text-align:center;padding-top:100px;"><h1 style="font-size:72px;">404</h1><p>Page not found</p><a href="/" style="color:#000;">Home</a></body></html>';
        }
        exit; // Прерываем выполнение, чтобы ничего лишнего не подгружалось
}

// 7. Собираем стандартную страницу (для 200 OK)
include __DIR__ . '/templates/header.php';

// Визуальный индикатор тестового сервера (Staging)
if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'test.emotionsbymail.com') {
    echo '<div style="position:fixed;top:10px;right:10px;background:#ff3b30;color:#ffffff;padding:6px 14px;font-size:12px;font-weight:bold;font-family:sans-serif;border-radius:20px;box-shadow:0 4px 12px rgba(255,59,48,0.4);z-index:99999;pointer-events:none;letter-spacing:0.5px;text-transform:uppercase;">🧪 TEST STAGING</div>';
}

include __DIR__ . '/templates/' . basename($template);
include __DIR__ . '/templates/footer.php';