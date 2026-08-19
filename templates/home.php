<?php 
// Определяем префикс для ссылок в зависимости от языка
$url_prefix = '/';
if ($lang === 'ru') {
    $url_prefix = '/ru/';
} elseif ($lang === 'en') {
    $url_prefix = '/en/';
}
?>

<!-- Заменили div на section для лучшего SEO и семантики -->
<section class="welcome-section" data-lang="<?= htmlspecialchars($lang) ?>">
    <!-- SEO Заголовок (Основное ключевое слово) -->
<h1 class="seo-title">
    <?= $texts['seo_h1'] ?? ($lang === 'ru' 
        ? 'Сервис писем поддержки&nbsp;и возможность выговориться по&nbsp;email' 
        : ($lang === 'en' 
            ? 'Personal letters of encouragement&nbsp;and a safe space to share your thoughts via&nbsp;email' 
            : 'Сервіс листів підтримки&nbsp;та можливість виговоритися по&nbsp;email')) ?>
</h1>

    <!-- Динамическое приветствие -->
    <p id="greetingTitle" class="greeting-text">
        <?php
        if ($lang === 'ru') {
            echo 'Добрый вечер<br>Мы всегда рядом';
        } elseif ($lang === 'en') {
            echo 'Good evening<br>We are always here for you';
        } else {
            echo 'Доброго вечора<br>Ми завжди поруч';
        }
        ?>
    </p>

    <!-- Подзаголовок -->
    <p class="welcome-subtitle"><?= htmlspecialchars($texts['choose_format'] ?? '') ?></p>
    
    <!-- Кнопки выбора формата -->
    <div class="buttons-container">
        <a href="<?= $url_prefix ?>paper" class="btn btn-paper"><?= htmlspecialchars($texts['btn_paper'] ?? 'Paper Letter') ?></a>
        <a href="<?= $url_prefix ?>digital" class="btn btn-digital"><?= htmlspecialchars($texts['btn_digital'] ?? 'Digital Support') ?></a>
    </div>

    <!-- Вложенный текстовый материал о сервисе -->
    <article class="about-service-section">
        <h2><?= htmlspecialchars($texts['promo_tagline'] ?? '') ?></h2>
        
        <p class="promo-intro-head"><strong><?= htmlspecialchars($texts['promo_intro_title'] ?? '') ?></strong></p>
        <p><?= htmlspecialchars($texts['promo_intro_text1'] ?? '') ?></p>
        <p><?= htmlspecialchars($texts['promo_intro_text2'] ?? '') ?></p>

        <hr class="promo-divider">

        <h3>✉️ <?= htmlspecialchars($texts['promo_about_heading'] ?? '') ?></h3>
        <p><?= htmlspecialchars($texts['promo_about_desc'] ?? '') ?></p>
        <p><span><?= $texts['promo_choose_format'] ?? '' ?></span></p>
        
        <!-- Оформленный список проектов со ссылкой ТОЛЬКО на название -->
       <ul class="promo-services-links">
    <li>
        <a href="<?= $url_prefix ?>digital"><?= htmlspecialchars($lang === 'ru' ? 'Анонимная Email-поддержка' : ($lang === 'en' ? 'Anonymous Email Support' : 'Анонімна Email-підтримка')) ?></a> <span style="white-space: nowrap;">• <?= htmlspecialchars($lang === 'ru' ? 'Цифровое тепло' : ($lang === 'en' ? 'Digital Warmth' : 'Цифрове тепло')) ?></span>
    </li>
    <li>
        <a href="<?= $url_prefix ?>paper"><?= htmlspecialchars($lang === 'ru' ? 'Сервис бумажных писем' : ($lang === 'en' ? 'Paper Letters Service' : 'Сервіс паперових листів')) ?></a> <span style="white-space: nowrap;">• <?= htmlspecialchars($lang === 'ru' ? 'Тактильное тепло' : ($lang === 'en' ? 'Tactile Warmth' : 'Тактильне тепло')) ?></span>
    </li>
</ul>
        
        <p class="promo-success-badge"><strong>✅ <?= htmlspecialchars($texts['promo_success'] ?? '') ?></strong></p>

<div class="promo-features-block">
    <h3>💡 <?= $texts['promo_why_title'] ?? '' ?></h3>
    <ul class="promo-features-list">
        <li>✉️ <span><?= $texts['promo_feat_1'] ?? '' ?></span></li>
        <li>🤝 <span><?= $texts['promo_feat_2'] ?? '' ?></span></li>
        <li>☕ <span><?= $texts['promo_feat_3'] ?? '' ?></span></li>
        <li>🎯 <span><?= $texts['promo_feat_4'] ?? '' ?></span></li>
        <li>⚓ <span><?= $texts['promo_feat_5'] ?? '' ?></span></li>
        <li>🔇 <span><?= $texts['promo_feat_6'] ?? '' ?></span></li>
    </ul>
</div>

        <h3><?= htmlspecialchars($texts['promo_simplicity_title'] ?? '') ?></h3>
        <p><?= htmlspecialchars($texts['promo_simplicity_text1'] ?? '') ?></p>
        <p><?= htmlspecialchars($texts['promo_simplicity_text2'] ?? '') ?></p>

        <?php if (!empty($texts['promo_quote'])): ?>
            <blockquote>«<?= htmlspecialchars($texts['promo_quote'] ?? '') ?>»</blockquote>
        <?php endif; ?>

        <div class="promo-cta-box">
            <h4><?= htmlspecialchars($texts['promo_offer_title'] ?? '') ?></h4>
            <p><?= htmlspecialchars($texts['promo_offer_text'] ?? '') ?></p>
            
            <a href="https://buymeacoffee.com/emotionsbymail" target="_blank" rel="noopener" class="promo-main-btn">
                ☕ <?= htmlspecialchars($texts['promo_cta_btn'] ?? '') ?>
            </a>

            <p class="promo-security-note">
                🔒 <?= htmlspecialchars($texts['promo_payment_security'] ?? '') ?>
            </p>
            <p class="promo-guarantees-note">
                <?= htmlspecialchars($texts['promo_guarantees'] ?? '') ?>
            </p>
        </div>
    </article>
</section>

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