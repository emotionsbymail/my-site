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
        <?= $texts['seo_title'] ?? $texts['seo_h1'] ?? '' ?>
    </h1>

    <!-- Динамическое приветствие (заполняется через JS) -->
    <p id="greetingTitle" class="greeting-text">
        <?= $texts['hero_greeting'] ?? '' ?>
    </p>

    <!-- Подзаголовок -->
    <p class="welcome-subtitle"><?= htmlspecialchars($texts['choose_format'] ?? $texts['hero_subtitle'] ?? '') ?></p>
    
    <!-- Кнопки выбора формата -->
    <div class="buttons-container">
        <a href="<?= $url_prefix ?>paper" class="btn btn-outline btn-full"><?= htmlspecialchars($texts['btn_paper'] ?? '') ?></a>
        <a href="<?= $url_prefix ?>digital" class="btn btn-primary btn-full"><?= htmlspecialchars($texts['btn_digital'] ?? '') ?></a>
    </div>

    <!-- Вложенный текстовый материал о сервисе -->
    <article class="about-service-section">
        <h2><?= htmlspecialchars($texts['promo_tagline'] ?? '') ?></h2>
        
        <p class="promo-intro-head"><strong><?= htmlspecialchars($texts['promo_intro_title'] ?? '') ?></strong></p>
        <p><?= htmlspecialchars($texts['promo_intro_text1'] ?? '') ?></p>
        <p><?= htmlspecialchars($texts['promo_intro_text2'] ?? '') ?></p>

        <hr class="promo-divider">

        <h3><?= htmlspecialchars($texts['promo_about_heading'] ?? '') ?></h3>
        <p><?= htmlspecialchars($texts['promo_about_desc'] ?? '') ?></p>
        <p><span><?= $texts['promo_choose_format'] ?? '' ?></span></p>
        
        <!-- Оформленный список проектов -->
        <ul class="promo-services-links">
            <li>
    <a href="<?= $url_prefix ?>digital"><?= htmlspecialchars($texts['nav_digital'] ?? '') ?></a> 
    <span style="white-space: nowrap;">• <?= htmlspecialchars($texts['promo_feat_1_tag'] ?? '') ?></span>
</li>
<li>
    <a href="<?= $url_prefix ?>paper"><?= htmlspecialchars($texts['nav_paper'] ?? '') ?></a> 
    <span style="white-space: nowrap;">• <?= htmlspecialchars($texts['promo_feat_2_tag'] ?? '') ?></span>
</li>
        </ul>
        
        <p class="promo-success-badge"><strong><?= $texts['promo_success'] ?? '' ?></strong></p>

        <!-- Почему выбирают наш сервис -->
        <div class="promo-features-block">
            <h3><?= $texts['promo_why_title'] ?? '' ?></h3>
            <ul class="promo-features-list">
                <li><span><?= $texts['promo_feat_1'] ?? '' ?></span></li>
                <li><span><?= $texts['promo_feat_2'] ?? '' ?></span></li>
                <li><span><?= $texts['promo_feat_3'] ?? '' ?></span></li>
                <li><span><?= $texts['promo_feat_4'] ?? '' ?></span></li>
                <li><span><?= $texts['promo_feat_5'] ?? '' ?></span></li>
                <li><span><?= $texts['promo_feat_6'] ?? '' ?></span></li>
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

        <h3><?= htmlspecialchars($texts['promo_simplicity_title'] ?? '') ?></h3>
        <p><?= htmlspecialchars($texts['promo_simplicity_text1'] ?? '') ?></p>
        <p><?= htmlspecialchars($texts['promo_simplicity_text2'] ?? '') ?></p>

        <?php if (!empty($texts['promo_quote'])): ?>
            <blockquote><?= htmlspecialchars($texts['promo_quote']) ?></blockquote>
        <?php endif; ?>

        <div class="promo-cta-box">
            <h4><?= htmlspecialchars($texts['promo_offer_title'] ?? '') ?></h4>
            <p><?= htmlspecialchars($texts['promo_offer_text'] ?? '') ?></p>
            
            <!-- Кнопки выбора формата -->
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
    </article>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const greetingElement = document.getElementById('greetingTitle');
    if (!greetingElement) return;

    const welcomeSection = document.querySelector('.welcome-section');
    const currentLang = welcomeSection ? welcomeSection.getAttribute('data-lang') : 'uk';

    const hours = new Date().getHours();
    
    // Словари приветствий прямо в JS для чистой динамической смены по времени
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