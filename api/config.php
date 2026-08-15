<?php
/**
 * Настройки конфигурации и безопасности
 */

// 1. Режим работы: 'production' (рабочий сайт) или 'development' (разработка)
define('APP_ENV', 'production'); 

if (APP_ENV === 'production') {
    // Отключаем вывод ошибок на экран для пользователей
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL);
    
    // Включаем логирование ошибок в отдельный закрытый файл
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
} else {
    // Режим разработки: показываем ошибки
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// 2. Возврат массива настроек
return [
    'app' => [
        'env' => APP_ENV,
        'subscribers_file' => __DIR__ . '/subscribers.txt',
    ],
    'telegram' => [
        'bot_token' => '8307799434:AAGrNNEU0VrQSMrtqCtw2S_HRGXe6dLyC98',
        'chat_id'   => '6369865563',
    ],
    'smtp' => [
        'host'       => 'm7.unlim.com',
        'user'       => 'robot@emotionsbymail.com',
        'pass'       => '!+mm@Z`v?@f~W$OesGKK',
        'port'       => 465,
        'from_email' => 'hello@emotionsbymail.com',
        'reply_to'   => 'noreply@emotionsbymail.com',
    ]
];