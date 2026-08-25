</main> <!-- Закрытие .page-content -->

<?php
// 1. Формируем правильный префикс для ссылок в меню
$prefix = '/';
if ($lang === 'ru') {
    $prefix = '/ru/';
} elseif ($lang === 'en') {
    $prefix = '/en/';
}

// 2. Ссылка для логотипа в футере
$footer_logo_url = '/';
if ($lang === 'ru') {
    $footer_logo_url = '/ru';
} elseif ($lang === 'en') {
    $footer_logo_url = '/en';
}
?>

<footer class="main-footer">
    <div class="container footer-content">
        <!-- Колонка 1: О проекте -->
        <div class="footer-col footer-about">
            <a href="<?= $footer_logo_url ?>" class="footer-logo">
                Emotions <span>by Mail</span>
            </a>
            <p>
                <?= $texts['footer_about'] ?? ($lang === 'ru' 
                    ? 'Действительно теплая и бережная эмоциональная поддержка в формате живых и электронных писем.' 
                    : ($lang === 'en' 
                        ? 'Truly warm and caring emotional support through handwritten and digital letters.' 
                        : 'Дійсно тепла та дбайлива емоційна підтримка у форматі живих та електронних листів.')) ?>
            </p>
        </div>

        <!-- Колонка 2: Навигация -->
        <div class="footer-col footer-links">
            <h4>
                <?= $texts['footer_sections'] ?? ($lang === 'ru' ? 'Разделы' : ($lang === 'en' ? 'Sections' : 'Розділи')) ?>
            </h4>
            <ul>
                <li>
                    <a href="<?= $prefix ?>paper">
                        <?= $texts['footer_paper'] ?? ($lang === 'ru' ? 'Бумажные письма' : ($lang === 'en' ? 'Paper Letters' : 'Паперові листи')) ?>
                    </a>
                </li>
                <li>
                    <a href="<?= $prefix ?>digital">
                        <?= $texts['footer_digital'] ?? ($lang === 'ru' ? 'Email-терапия' : ($lang === 'en' ? 'Share Your Thoughts via Email' : 'Email-терапія')) ?>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Колонка 3: Контакты -->
        <div class="footer-col footer-contacts">
            <h4>
                <?= $texts['footer_contact'] ?? ($lang === 'ru' ? 'Связь с нами' : ($lang === 'en' ? 'Contact Us' : 'Зв’язок з нами')) ?>
            </h4>
            <p class="footer-email-row">
                Email: 
                <a href="mailto:info@emotionsbymail.com" class="email-link" title="Открыть в почтовом клиенте">
                    info@emotionsbymail.com
                </a>
                <button type="button" 
                        class="copy-btn" 
                        onclick="copyEmailToClipboard('info@emotionsbymail.com')" 
                        title="Скопировать email">
                    <svg class="copy-icon" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                        <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                    </svg>
                </button>
            </p>
            <p>Instagram: <a href="https://instagram.com/emotionsbymail" target="_blank" rel="noopener">@emotionsbymail</a></p>
        </div>

        <!-- Колонка 4: Акцентный штемпель/Печать качества (Кнопка «Наверх») -->
        <div class="footer-col footer-stamp-col">
            <div class="footer-stamp-wrapper" 
                 title="Emotions by Mail Quality Stamp" 
                 onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" 
                 style="cursor: pointer;">
                <img src="/assets/images/logo-bimi.svg" alt="Emotions by Mail Stamp" class="footer-stamp-img">
            </div>
        </div>
    </div> <!-- / .footer-content правильное закрытие колонок -->

    <!-- Дисклеймер безопасности -->
    <div class="container">
        <div class="footer-disclaimer">
            <?= $texts['footer_disclaimer'] ?? ($lang === 'ru' 
                ? 'Важно: Сервис предоставляет эмоциональную поддержку, но не заменяет профессиональную психотерапию или экстренную медицинскую помощь. Если вы находитесь в тяжелом кризисном состоянии, обратитесь на линию поддержки Lifeline Ukraine по номеру 7333.' 
                : ($lang === 'en' 
                    ? 'Important: This service provides emotional support but does not replace professional psychotherapy or emergency medical care. If you are in a severe crisis, please reach out to local mental health support or Lifeline Ukraine at 7333.' 
                    : 'Важливо: Сервіс надає емоційну підтримку, але не замінює професійну психотерапію або екстрену медичну службу. Якщо ви перебуваєте у важкому кризовому стані, зверніться на лінію підтримки Lifeline Ukraine за номером 7333.')) ?>
        </div>
    </div>

    <!-- Копирайт -->
    <div class="footer-bottom">
        <div class="container footer-bottom-content">
            <span>&copy; <?= date('Y') ?> Emotions by Mail</span>
            <span class="copyright-divider">│</span>
            <span><?= 
                $lang === 'ru' ? 'Все права защищены.' : 
                ($lang === 'en' ? 'All rights reserved.' : 'Усі права захищені.') 
            ?></span>
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
</footer>

</body>
</html>