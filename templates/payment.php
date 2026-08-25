<?php
// Определение текущего языка (по умолчанию 'uk')
$lang = $lang ?? 'uk';

// Загрузка словаря
$langFile = __DIR__ . "/../lang/{$lang}.php";
$fallbackFile = __DIR__ . "/../lang/uk.php";

if (file_exists($langFile)) {
    $t = require $langFile;
} elseif (file_exists($fallbackFile)) {
    $t = require $fallbackFile;
} else {
    $t = [];
}

$texts = $t;

$url_prefix = '/';
if ($lang === 'ru') {
    $url_prefix = '/ru/';
} elseif ($lang === 'en') {
    $url_prefix = '/en/';
}
?>

<div class="container">
    <section class="welcome-section payment-guide-section" data-lang="<?= htmlspecialchars($lang) ?>">
        <!-- SEO Заголовок -->
        <h1 class="seo-title">
            <?= $texts['payment_title'] ?? '' ?>
        </h1>

        <p class="greeting-text">
            <?= $texts['payment_intro'] ?? '' ?>
        </p>

        <!-- Пошаговые блоки -->
        <div class="promo-features-block payment-steps">
            <div class="promo-features-list payment-steps-grid">
                <!-- Шаг 1 -->
                <div class="payment-step-card">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3 class="step-title">
                            <?= htmlspecialchars($texts['payment_step_1_title'] ?? '') ?>
                        </h3>
                        <p class="step-desc">
                            <?= htmlspecialchars($texts['payment_step_1_desc'] ?? '') ?>
                        </p>
                        <div class="step-image-wrapper">
                            <img src="/assets/images/payment/step-1.webp" alt="Step 1" loading="lazy" class="step-image">
                        </div>
                    </div>
                </div>

                <!-- Шаг 2 -->
                <div class="payment-step-card">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3 class="step-title">
                            <?= htmlspecialchars($texts['payment_step_2_title'] ?? '') ?>
                        </h3>
                        <p class="step-desc">
                            <?= htmlspecialchars($texts['payment_step_2_desc'] ?? '') ?>
                        </p>
                        <div class="step-image-wrapper">
                            <img src="/assets/images/payment/step-2.webp" alt="Step 2" loading="lazy" class="step-image">
                        </div>
                    </div>
                </div>

                <!-- Шаг 3 -->
                <div class="payment-step-card">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3 class="step-title">
                            <?= htmlspecialchars($texts['payment_step_3_title'] ?? '') ?>
                        </h3>
                        <p class="step-desc">
                            <?= htmlspecialchars($texts['payment_step_3_desc'] ?? '') ?>
                        </p>
                        <div class="step-image-wrapper">
                            <img src="/assets/images/payment/step-3.webp" alt="Step 3" loading="lazy" class="step-image">
                        </div>
                    </div>
                </div>
                
                <!-- Шаг 4 -->
                <div class="payment-step-card">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3 class="step-title">
                            <?= htmlspecialchars($texts['payment_step_4_title'] ?? '') ?>
                        </h3>
                        <p class="step-desc">
                            <?= htmlspecialchars($texts['payment_step_4_desc'] ?? '') ?>
                        </p>
                        <div class="step-image-wrapper">
                            <img src="/assets/images/payment/step-4.webp" alt="Step 4" loading="lazy" class="step-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопка перехода к оплате -->
        <div class="promo-cta-box">
            <h4>
                <?= htmlspecialchars($texts['payment_cta_title'] ?? '') ?>
            </h4>
            <p>
                <?= htmlspecialchars($texts['payment_cta_desc'] ?? '') ?>
            </p>
            <a href="https://buymeacoffee.com/emotionsbymail" target="_blank" rel="noopener" class="promo-main-btn">
                ☕ <?= htmlspecialchars($texts['payment_cta_btn'] ?? '') ?>
            </a>
            <p class="promo-security-note">🔒 Buy Me a Coffee</p>
        </div>
    </section>

    <!-- FAQ Блок -->
    <?php if (!empty($texts['payment_faq']) && is_array($texts['payment_faq'])): ?>
    <section class="faq-section">
        <h2 class="faq-title"><?= htmlspecialchars($texts['payment_faq_title'] ?? '') ?></h2>
        <div class="faq-accordion">
            <?php foreach ($texts['payment_faq'] as $item): ?>
                <details class="faq-item">
                    <summary class="faq-question">
                        <span><?= htmlspecialchars($item['q'] ?? '') ?></span>
                        <span class="faq-icon">❯</span>
                    </summary>
                    <div class="faq-answer">
                        <p><?= $item['a'] ?? '' ?></p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>