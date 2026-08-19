<?php
// Вывод ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Определение текущего языка (по умолчанию 'uk')
$lang = $lang ?? 'uk';

// Учитываем, что paper.php находится в /templates/, а языки — в /lang/ уровнем выше
$langFile = __DIR__ . "/../lang/{$lang}.php";
$fallbackFile = __DIR__ . "/../lang/uk.php";

// Безопасное подключение файла локализации
if (file_exists($langFile)) {
    $t = require $langFile;
} elseif (file_exists($fallbackFile)) {
    $t = require $fallbackFile;
} else {
    $t = [];
}

// Алиас для обратной совместимости, если где-то используется $texts
$texts = $t;
?>

<section class="welcome-section">
    <p class="seo-title"><?=  $t['paper_seo_title'] ?? '' ?></p>
    <h1 class="greeting-text"><?= htmlspecialchars($t['welcome_heading'] ?? $t['paper_title'] ?? '') ?></h1>
    <p class="welcome-subtitle">
        <?= $t['welcome_subtitle'] ?? $t['paper_desc'] ?? '' ?>
    </p>
    
    <p class="launch-bonus-1">
        <?= $t['welcome_bonus_text_1'] ?? '' ?>
    </p>

    <!-- Форма подписки встроенная прямо в секцию -->
    <div class="inline-notify-form-container">
        <form id="notifyForm" class="welcome-inline-form">
            <!-- Скрытое поле языка для точного определения скриптом -->
            <input type="hidden" id="pageLang" value="<?= htmlspecialchars($lang) ?>">
            
            <!-- Honeypot поля для защиты от спам-ботов -->
            <input type="text" name="b_website" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
            <input type="text" name="phone_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">

            <input type="email" id="notifyEmailInput" required placeholder="<?= htmlspecialchars($t['input_email_placeholder'] ?? '') ?>" class="modal-input inline-input">
            <button type="submit" class="btn btn-paper inline-submit-btn"><?= htmlspecialchars($t['btn_submit'] ?? $t['btn_notify_launch'] ?? '') ?></button>
        </form>
    </div>

    <p class="launch-bonus">
        <?= $t['welcome_bonus_text'] ?? '' ?>
    </p>
</section>

<?php 
$faqData = $t['paper_faq'] ?? $texts['paper_faq'] ?? null;
$faqTitle = $t['paper_faq_title'] ?? $texts['paper_faq_title'] ?? '';

if (!empty($faqData) && is_array($faqData)): 
?>
<section class="faq-section">
    <h2 class="faq-title"><?= htmlspecialchars($faqTitle) ?></h2>
    
    <div class="faq-accordion">
        <?php foreach ($faqData as $item): ?>
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

<!-- Модальное окно ТОЛЬКО для результатов (Успех / Повторная подписка) -->
<div id="notifyModal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <button type="button" class="modal-close" onclick="closeNotifyModal()">&times;</button>

        <!-- Блок для НОВОЙ подписки -->
        <div id="notifySuccess" class="modal-success" style="display: none; text-align: center; padding: 10px 0;">
            <div class="success-icon" style="font-size: 2.5rem; margin-bottom: 10px;">✨</div>
            <h3 class="modal-title" style="margin-bottom: 8px;"><?= htmlspecialchars($t['modal_success_title'] ?? '') ?></h3>
            <p class="modal-desc" style="margin: 0 0 10px 0;">
                <?= htmlspecialchars($t['modal_success_desc1'] ?? '') ?>
            </p>
            <p class="modal-desc" style="margin: 0 0 6px 0; font-size: 0.95rem; opacity: 0.9;">
                <?= htmlspecialchars($t['modal_success_desc2'] ?? '') ?>
            </p>
            <div class="user-entered-email-wrap" style="margin: 8px 0 12px 0; text-align: center;">
                <span id="userEnteredEmail" class="user-entered-email"></span>
            </div>
            <p class="modal-desc" style="margin: 0; font-size: 0.9rem; opacity: 0.85;">
                <?= $t['modal_success_spam'] ?? '' ?>
            </p>
        </div>

        <!-- Блок для ПОВТОРНОЙ подписки -->
        <div id="notifyAlready" class="modal-success" style="display: none; text-align: center; padding: 10px 0;">
            <div class="success-icon" style="font-size: 2.5rem; margin-bottom: 10px;">✨</div>
            <h3 class="modal-title" style="margin-bottom: 8px;"><?= htmlspecialchars($t['modal_already_title'] ?? '') ?></h3>
            <p class="modal-desc" style="margin: 0 0 10px 0;"><?= htmlspecialchars($t['modal_already_desc'] ?? '') ?></p>
            
            <!-- Отображаем email при повторном вводе -->
            <div class="user-entered-email-wrap" style="margin: 8px 0 12px 0; text-align: center;">
                <span class="user-entered-email userEnteredEmailClass"></span>
            </div>
        </div>
    </div>
</div>
<!-- Модальный оверлей с центральным уведомлением -->
<div id="copyOverlay" class="copy-overlay">
    <div class="copy-modal">
        <div class="copy-icon">✨</div>
        <div class="copy-message">
            <?= htmlspecialchars($texts['toast_copied'] ?? 'Адрес скопирован!') ?>
        </div>
    </div>
</div>