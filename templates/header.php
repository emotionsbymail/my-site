<?php
// Формируем корректный чистый путь страницы
$path = !empty($clean_route) ? trim($clean_route, '/') : '';

// Ссылки для каждой языковой версии (для переключателя языков)
$ua_url = '/' . $path;
$ru_url = '/ru' . ($path ? '/' . $path : '');
$en_url = '/en' . ($path ? '/' . $path : '');

// Формируем языковой префикс для внутренних ссылок навигации
$lang_prefix = '';
if ($lang === 'ru') {
    $lang_prefix = '/ru';
} elseif ($lang === 'en') {
    $lang_prefix = '/en';
}

// Ссылка для логотипа
$logo_url = $lang_prefix ?: '/';

// Ссылки на страницы "Цифровое тепло" (digital) и "Тактильное тепло" (paper)
$digital_url = $lang_prefix . '/digital';
$paper_url   = $lang_prefix . '/paper';

// Приводим код языка для проверки активной кнопки (поддерживаем и uk, и ua)
$is_uk_active = ($lang === 'uk' || $lang === 'ua');

// Безопасное определение HTML-языка
$html_lang = $lang === 'ru' ? 'ru' : ($lang === 'en' ? 'en' : 'uk');

// Подготовка заголовка страницы (Title)
$og_title = $page_title ?? 'Emotions by Mail';

// Подготовка мета-описания (Description)
$page_description = $page_description ?? ($lang === 'ru' 
    ? 'Действительно теплая и бережная эмоциональная поддержка в формате живых и электронных писем.' 
    : ($lang === 'en' 
        ? 'Truly warm and caring emotional support through handwritten and digital letters.' 
        : 'Дійсно тепла та дбайлива емоційна підтримка у форматі живих та електронних листів.'));

// Полный абсолютный URL текущей страницы
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$current_full_url = $protocol . ($_SERVER['HTTP_HOST'] ?? 'emotionsbymail.com') . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($html_lang, ENT_QUOTES, 'UTF-8') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ЗАПРЕТ ИНДЕКСАЦИИ ДЛЯ ТЕСТОВОГО СТЕНДА -->
    <meta name="robots" content="noindex, nofollow, noarchive">
    <meta name="googlebot" content="noindex, nofollow">
    
    <!-- Основные метатеги -->
    <title><?= htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Open Graph (Telegram, Viber, Facebook и др.) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($current_full_url, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:title" content="<?= htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:image" content="https://emotionsbymail.com/assets/images/logo-og.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter / X (Формат summary делает картинку маленькой и справа от текста) -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= htmlspecialchars($og_title, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="https://emotionsbymail.com/assets/images/logo-og.png">

    <!-- Подключение шрифта Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS стили -->
    <link rel="stylesheet" href="/assets/css/style.css?v=8.8.121">

    <!-- Альтернативные языковые версии (относительные пути для тестовой среды) -->
    <link rel="alternate" hreflang="uk" href="<?= htmlspecialchars($ua_url, ENT_QUOTES, 'UTF-8') ?>" />
    <link rel="alternate" hreflang="ru" href="<?= htmlspecialchars($ru_url, ENT_QUOTES, 'UTF-8') ?>" />
    <link rel="alternate" hreflang="en" href="<?= htmlspecialchars($en_url, ENT_QUOTES, 'UTF-8') ?>" />
    <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($ua_url, ENT_QUOTES, 'UTF-8') ?>" />

    <!-- Подключение фавиконки (Favicon) -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="EmByMail" />
    <link rel="manifest" href="/site.webmanifest" />

    <!-- Проверка темы ДО рендера страницы (предотвращает мерцание белым фоном) -->
    <script>
        (function() {
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark-mode');
                }
            } catch(e) {}
        })();
    </script>
</head>
<body>

<!-- Скрытое поле с языком страницы для JS скриптов (экранировано) -->
<input type="hidden" id="pageLang" value="<?= htmlspecialchars($html_lang, ENT_QUOTES, 'UTF-8') ?>">

<header class="main-header">
    <div class="container header-content">
        <!-- Логотип -->
        <a href="<?= htmlspecialchars($logo_url, ENT_QUOTES, 'UTF-8') ?>" class="logo">
            Emotions <span>by Mail</span>
        </a>

        <!-- Мобильная кнопка «Бургер» -->
        <button class="burger-menu" id="burgerBtn" type="button" aria-label="Toggle Navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Обертка навигации, переключателя языков и темы -->
        <div class="nav-wrapper" id="navWrapper">
            <!-- Главное меню навигации -->
            <nav class="main-nav">
                <a href="<?= htmlspecialchars($digital_url, ENT_QUOTES, 'UTF-8') ?>" class="nav-link <?= $path === 'digital' ? 'active' : '' ?>">
                    <?= htmlspecialchars($texts['nav_digital'] ?? 'Email-поддержка', ENT_QUOTES, 'UTF-8') ?>
                </a>
                <span class="nav-divider">|</span>
                <a href="<?= htmlspecialchars($paper_url, ENT_QUOTES, 'UTF-8') ?>" class="nav-link <?= $path === 'paper' ? 'active' : '' ?>">
                    <?= htmlspecialchars($texts['nav_paper'] ?? 'Бумажные письма', ENT_QUOTES, 'UTF-8') ?>
                </a>
            </nav>

            <!-- Переключатель языков UA / RU / EN -->
            <div class="lang-switcher">
                <a href="<?= htmlspecialchars($ua_url, ENT_QUOTES, 'UTF-8') ?>" 
                   class="lang-btn <?= $is_uk_active ? 'active' : '' ?>">
                   UA
                </a>
                <span class="lang-divider">|</span>
                <a href="<?= htmlspecialchars($ru_url, ENT_QUOTES, 'UTF-8') ?>" 
                   class="lang-btn <?= $lang === 'ru' ? 'active' : '' ?>">
                   RU
                </a>
                <span class="lang-divider">|</span>
                <a href="<?= htmlspecialchars($en_url, ENT_QUOTES, 'UTF-8') ?>" 
                   class="lang-btn <?= $lang === 'en' ? 'active' : '' ?>">
                   EN
                </a>
            </div>

            <!-- Кнопка переключения темы -->
            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle Theme">🌙</button>
        </div>
    </div>
</header>

<script src="/assets/js/main.js?v=1.1" defer></script>

<main class="page-content">