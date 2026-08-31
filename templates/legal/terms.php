<?php
// Вывод ошибок для отладки (при необходимости можно отключить)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Определение текущего языка (по умолчанию 'uk')
$lang = $lang ?? 'uk';

// Учитываем, что файл находится в /templates/legal/, поэтому поднимаемся на 2 уровня вверх до /lang/
$langFile = __DIR__ . "/../../lang/{$lang}.php";
$fallbackFile = __DIR__ . "/../../lang/uk.php";

// Безопасное подключение файла локализации
if (file_exists($langFile)) {
    $t = require $langFile;
} elseif (file_exists($fallbackFile)) {
    $t = require $fallbackFile;
} else {
    $t = [];
}

// Алиас для обратной совместимости
$texts = $t;
?>

<main class="legal-container">
    <h1><?= $t['terms_h1'] ?? 'Умови використання' ?></h1>
    
    <?php if (!empty($t['terms_last_updated'])): ?>
        <p class="last-updated"><?= htmlspecialchars($t['terms_last_updated']) ?></p>
    <?php endif; ?>

    <div class="legal-content">
        <!-- Intro -->
        <?php if (!empty($t['terms_intro_1'])): ?>
            <p><?= $t['terms_intro_1'] ?></p>
        <?php endif; ?>

        <hr>

        <!-- Section 1 -->
        <?php if (!empty($t['terms_s1_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s1_title']) ?></h2>
            <p><?= $t['terms_s1_intro'] ?? '' ?></p>
            <ul>
                <?php if (!empty($t['terms_s1_item1'])): ?><li><?= $t['terms_s1_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s1_item2'])): ?><li><?= $t['terms_s1_item2'] ?></li><?php endif; ?>
            </ul>
            <?php if (!empty($t['terms_s1_disclaimer'])): ?>
                <p><?= $t['terms_s1_disclaimer'] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <hr>

        <!-- Section 2 -->
        <?php if (!empty($t['terms_s2_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s2_title']) ?></h2>
            <ul>
                <?php if (!empty($t['terms_s2_item1'])): ?><li><?= $t['terms_s2_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s2_item2'])): ?><li><?= $t['terms_s2_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 3 -->
        <?php if (!empty($t['terms_s3_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s3_title']) ?></h2>
            <ul>
                <?php if (!empty($t['terms_s3_item1'])): ?><li><?= $t['terms_s3_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s3_item2'])): ?><li><?= $t['terms_s3_item2'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s3_item3'])): ?><li><?= $t['terms_s3_item3'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s3_item4'])): ?><li><?= $t['terms_s3_item4'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 4 -->
        <?php if (!empty($t['terms_s4_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s4_title']) ?></h2>
            <ul>
                <?php if (!empty($t['terms_s4_item1'])): ?><li><?= $t['terms_s4_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['terms_s4_item2'])): ?><li><?= $t['terms_s4_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 5 -->
        <?php if (!empty($t['terms_s5_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s5_title']) ?></h2>
            <p><?= $t['terms_s5_text'] ?? '' ?></p>
        <?php endif; ?>

        <hr>

        <!-- Section 6 -->
        <?php if (!empty($t['terms_s6_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s6_title']) ?></h2>
            <p><?= $t['terms_s6_text'] ?? '' ?></p>
        <?php endif; ?>

        <hr>

        <!-- Section 7 -->
        <?php if (!empty($t['terms_s7_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s7_title']) ?></h2>
            <p><?= $t['terms_s7_text'] ?? '' ?></p>
        <?php endif; ?>

        <hr>

        <!-- Section 8 -->
        <?php if (!empty($t['terms_s8_title'])): ?>
            <h2><?= htmlspecialchars($t['terms_s8_title']) ?></h2>
            <p><?= $t['terms_s8_intro'] ?? '' ?></p>
            <ul>
                <?php if (!empty($t['terms_s8_contact'])): ?>
                    <li><?= $t['terms_s8_contact'] ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</main>