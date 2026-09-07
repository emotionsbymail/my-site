<?php 
// Определяем префикс для ссылок в зависимости от языка
$url_prefix = '/';
if ($lang === 'ru') {
    $url_prefix = '/ru/';
} elseif ($lang === 'en') {
    $url_prefix = '/en/';
}
?>

<section class="welcome-section" data-lang="<?= htmlspecialchars($lang) ?>">
    <!-- SEO Заголовок -->
    <h1 class="seo-title">
        <?= $texts['seo_title'] ?? 'Emotions by Mail' ?>
    </h1>

    <!-- Динамическое приветствие -->
    <p id="greetingTitle" class="greeting-text">
        <?= $texts['hero_greeting'] ?? '' ?>
    </p>

    <!-- Подзаголовок -->
    <p class="welcome-subtitle"><?= htmlspecialchars($texts['choose_format'] ?? $texts['hero_subtitle'] ?? '') ?></p>
    
    <!-- Первичные кнопки вызова к действию -->
    <div class="buttons-container">
        <a href="<?= $url_prefix ?>paper" class="btn btn-outline btn-full"><?= htmlspecialchars($texts['btn_paper'] ?? '') ?></a>
        <a href="<?= $url_prefix ?>digital" class="btn btn-primary btn-full"><?= htmlspecialchars($texts['btn_digital'] ?? '') ?></a>
    </div>

    <!-- Заголовок перед карточками -->
    <h2 class="formats-section-title">
        <?= htmlspecialchars($texts['how_to_choose_title'] ?? '') ?>
    </h2>

    <!-- 2 Параллельные кликабельные карточки форматов -->
    <div class="formats-container">
        <!-- Карточка 1: Тактильное тепло -->
        <a href="<?= $url_prefix ?>paper" class="format-card">
            <div class="format-card-header">
                <span class="format-icon">📜</span>
                <h3><?= htmlspecialchars($texts['card_paper_title'] ?? '') ?></h3>
            </div>
            <p class="format-subtitle"><?= htmlspecialchars($texts['card_paper_desc'] ?? '') ?></p>

            <div class="format-for-whom">
                <strong>💡 <?= htmlspecialchars($texts['for_whom_label'] ?? 'Для кого:') ?></strong> <?= htmlspecialchars($texts['card_paper_for_whom'] ?? '') ?>
            </div>

            <ul class="format-features">
                <li><?= htmlspecialchars($texts['card_paper_feat_1'] ?? '') ?></li>
                <li><?= htmlspecialchars($texts['card_paper_feat_2'] ?? '') ?></li>
                <li><?= htmlspecialchars($texts['card_paper_feat_3'] ?? '') ?></li>
            </ul>
            <div class="format-card-link">
                <?= htmlspecialchars($texts['card_more_details'] ?? '') ?> →
            </div>
        </a>

        <!-- Карточка 2: Цифровое тепло -->
        <a href="<?= $url_prefix ?>digital" class="format-card">
            <div class="format-card-header">
                <span class="format-icon">✉️</span>
                <h3><?= htmlspecialchars($texts['card_digital_title'] ?? '') ?></h3>
            </div>
            <p class="format-subtitle"><?= htmlspecialchars($texts['card_digital_desc'] ?? '') ?></p>

            <div class="format-for-whom">
                <strong>💡 <?= htmlspecialchars($texts['for_whom_label'] ?? 'Для кого:') ?></strong> <?= htmlspecialchars($texts['card_digital_for_whom'] ?? '') ?>
            </div>

            <ul class="format-features">
                <li><?= htmlspecialchars($texts['card_digital_feat_1'] ?? '') ?></li>
                <li><?= htmlspecialchars($texts['card_digital_feat_2'] ?? '') ?></li>
                <li><?= htmlspecialchars($texts['card_digital_feat_3'] ?? '') ?></li>
            </ul>
            <div class="format-card-link">
                <?= htmlspecialchars($texts['card_more_details'] ?? '') ?> →
            </div>
        </a>
    </div>

    <!-- Блок преимуществ -->
    <div class="promo-features-block">
        <h3><?= $texts['promo_why_title'] ?? '' ?></h3>
        <ul class="promo-features-list">
            <li><span><?= $texts['promo_feat_1'] ?? '' ?></span></li>
            <li><span><?= $texts['promo_feat_2'] ?? '' ?></span></li>
            <li><span><?= $texts['promo_feat_3'] ?? '' ?></span></li>
            <li><span><?= $texts['promo_feat_4'] ?? '' ?></span></li>
        </ul>
    </div>

    <!-- Дыхательный тренажер -->
    <div class="anti-stress-box" id="breathingBox">
        <p class="anti-stress-title">
            <?= htmlspecialchars($texts['breathe_title'] ?? '') ?>
        </p>
        
        <div class="breathing-circle-wrapper">
            <div class="breathing-circle" id="breathingCircle"></div>
            <span class="breathing-text" id="breathingText"
                  data-inhale="<?= htmlspecialchars($texts['breathe_inhale'] ?? '') ?>"
                  data-pause="<?= htmlspecialchars($texts['breathe_pause'] ?? '') ?>"
                  data-exhale="<?= htmlspecialchars($texts['breathe_exhale'] ?? '') ?>">
            </span>
        </div>

        <div class="breathing-controls" style="margin-top: 15px; text-align: center;">
            <button type="button" class="btn-breathing-start" id="breathingToggleBtn"
                    data-start="<?= htmlspecialchars($texts['breathe_start'] ?? '') ?>"
                    data-stop="<?= htmlspecialchars($texts['breathe_stop'] ?? '') ?>">
                <?= htmlspecialchars($texts['breathe_start'] ?? '') ?>
            </button>
        </div>

        <p class="anti-stress-hint" id="breathingStatus"
           data-counter="<?= htmlspecialchars($texts['breathe_counter'] ?? '') ?>"
           data-done="<?= htmlspecialchars($texts['breathe_done'] ?? '') ?>">
        </p>
    </div>

    <!-- Финальный CTA блок -->
    <div class="promo-cta-box">
        <h4><?= htmlspecialchars($texts['promo_offer_title'] ?? '') ?></h4>
        <p><?= htmlspecialchars($texts['promo_offer_text'] ?? '') ?></p>
        
        <div class="buttons-container">
            <a href="<?= $url_prefix ?>paper" class="btn btn-outline btn-full"><?= htmlspecialchars($texts['btn_paper'] ?? '') ?></a>
            <a href="<?= $url_prefix ?>digital" class="btn btn-primary btn-full"><?= htmlspecialchars($texts['btn_digital'] ?? '') ?></a>
        </div>

        <p class="promo-security-note">
            <?= $texts['promo_payment_security'] ?? '' ?>
        </p>
        <p class="promo-guarantees-note">
            <?= htmlspecialchars($texts['promo_guarantees'] ?? '') ?>
        </p>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const greetingElement = document.getElementById('greetingTitle');
    if (!greetingElement) return;

    const welcomeSection = document.querySelector('.welcome-section');
    const currentLang = welcomeSection ? welcomeSection.getAttribute('data-lang') : 'uk';

    const hours = new Date().getHours();
    
    const greetings = {
        ru: {
            morning: 'Доброе утро<br>Мы всегда рядом',
            afternoon: 'Добрый день<br>Мы всегда рядом',
            evening: 'Добрый вечер<br>Мы всегда рядом',
            night: 'Доброй ночи<br>Мы всегда рядом'
        },
        en: {
            morning: 'Good morning<br>We are always here for you',
            afternoon: 'Good afternoon<br>We are always here for you',
            evening: 'Good evening<br>We are always here for you',
            night: 'Good night<br>We are always here for you'
        },
        uk: {
            morning: 'Доброго ранку<br>Ми завжди поруч',
            afternoon: 'Доброго дня<br>Ми завжди поруч',
            evening: 'Доброго вечора<br>Ми завжди поруч',
            night: 'Доброї ночі<br>Ми завжди поруч'
        }
    };

    const langDict = greetings[currentLang] || greetings['uk'];
    let timeKey = 'night';

    if (hours >= 5 && hours < 12) {
        timeKey = 'morning';
    } else if (hours >= 12 && hours < 18) {
        timeKey = 'afternoon';
    } else if (hours >= 18 && hours < 23) {
        timeKey = 'evening';
    }

    greetingElement.innerHTML = langDict[timeKey];
});
</script>