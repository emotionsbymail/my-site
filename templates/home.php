<?php 
// Определяем префикс для ссылок в зависимости от языка
$url_prefix = '/';
if ($lang === 'ru') {
    $url_prefix = '/ru/';
} elseif ($lang === 'en') {
    $url_prefix = '/en/';
}
?>

<div class="welcome-section" data-lang="<?= htmlspecialchars($lang) ?>">
    <!-- SEO Заголовок (Основное ключевое слово для поисковиков) -->
    <h1 class="seo-title">
        <?= htmlspecialchars($texts['seo_h1'] ?? ($lang === 'ru' 
            ? 'Сервис писем поддержки и возможность выговориться по email' 
            : ($lang === 'en' 
                ? 'Personal letters of encouragement and a safe space to share your thoughts via email' 
                : 'Сервіс листів підтримки та можливість виговоритися по email'))) ?>
    </h1>

    <!-- Динамическое приветствие по времени суток -->
    <p id="greetingTitle" class="greeting-text">
        <?php
        if ($lang === 'ru') {
            echo 'Добрый вечер<br>Мы всегда рядом';
        } elseif ($lang === 'en') {
            echo 'Good evening<br>We are always here for you';
        } else {
            // Версия по умолчанию (uk / ua)
            echo 'Доброго вечора<br>Ми завжди поруч';
        }
        ?>
    </p>

    <!-- Подзаголовок с выбором формата -->
    <p class="welcome-subtitle"><?= htmlspecialchars($texts['choose_format'] ?? '') ?></p>
    
    <div class="buttons-container">
        <!-- Ссылки формируются динамически: /paper, /ru/paper или /en/paper -->
        <a href="<?= $url_prefix ?>paper" class="btn btn-paper"><?= htmlspecialchars($texts['btn_paper'] ?? 'Paper Letter') ?></a>
        <a href="<?= $url_prefix ?>digital" class="btn btn-digital"><?= htmlspecialchars($texts['btn_digital'] ?? 'Digital Support') ?></a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const greetingElement = document.getElementById('greetingTitle');
    if (!greetingElement) return;

    // Точно определяем язык прямо из PHP-контекста контейнера
    const welcomeSection = document.querySelector('.welcome-section');
    const currentLang = welcomeSection ? welcomeSection.getAttribute('data-lang') : 'uk';

    const hours = new Date().getHours();
    let greetingText = '';

    // Логика времени суток с переносом строки <br>:
    if (currentLang === 'ru') {
        if (hours >= 5 && hours < 12) {
            greetingText = 'Доброе утро<br>Мы всегда рядом';
        } else if (hours >= 12 && hours < 18) {
            greetingText = 'Добрый день<br>Мы всегда рядом';
        } else if (hours >= 18 && hours < 23) {
            greetingText = 'Добрый вечер<br>Мы всегда рядом';
        } else {
            greetingText = 'Доброй ночи<br>Мы всегда рядом';
        }
    } else if (currentLang === 'en') {
        if (hours >= 5 && hours < 12) {
            greetingText = 'Good morning<br>We are always here for you';
        } else if (hours >= 12 && hours < 18) {
            greetingText = 'Good afternoon<br>We are always here for you';
        } else if (hours >= 18 && hours < 23) {
            greetingText = 'Good evening<br>We are always here for you';
        } else {
            greetingText = 'Good night<br>We are always here for you';
        }
    } else { 
        // Украинская версия (uk / ua)
        if (hours >= 5 && hours < 12) {
            greetingText = 'Доброго ранку<br>Ми завжди поруч';
        } else if (hours >= 12 && hours < 18) {
            greetingText = 'Доброго дня<br>Ми завжди поруч';
        } else if (hours >= 18 && hours < 23) {
            greetingText = 'Доброго вечора<br>Ми завжди поруч';
        } else {
            greetingText = 'Доброї ночі<br>Ми завжди поруч';
        }
    }

    // Использование innerHTML для сохранения тега <br>
    greetingElement.innerHTML = greetingText;
});
</script>
