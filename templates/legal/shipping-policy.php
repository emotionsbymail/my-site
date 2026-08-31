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
    <h1><?= $t['shipping_h1'] ?? 'Політика доставки' ?></h1>
    
    <?php if (!empty($t['shipping_last_updated'])): ?>
        <p class="last-updated"><?= htmlspecialchars($t['shipping_last_updated']) ?></p>
    <?php endif; ?>

    <div class="legal-content">
        <!-- Intro -->
        <?php if (!empty($t['shipping_intro_1'])): ?>
            <p><?= $t['shipping_intro_1'] ?></p>
        <?php endif; ?>

        <hr>

        <!-- Section 1 -->
        <?php if (!empty($t['shipping_s1_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s1_title']) ?></h2>
            <ul>
                <?php if (!empty($t['shipping_s1_item1'])): ?><li><?= $t['shipping_s1_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s1_item2'])): ?><li><?= $t['shipping_s1_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 2 -->
        <?php if (!empty($t['shipping_s2_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s2_title']) ?></h2>
            <ul>
                <?php if (!empty($t['shipping_s2_item1'])): ?><li><?= $t['shipping_s2_item1'] ?></li><?php endif; ?>
            </ul>
            
            <?php if (!empty($t['shipping_s2_intro_time'])): ?>
                <p><?= $t['shipping_s2_intro_time'] ?></p>
            <?php endif; ?>

            <ul>
                <?php if (!empty($t['shipping_s2_time1'])): ?><li><?= $t['shipping_s2_time1'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s2_time2'])): ?><li><?= $t['shipping_s2_time2'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s2_time3'])): ?><li><?= $t['shipping_s2_time3'] ?></li><?php endif; ?>
            </ul>

            <?php if (!empty($t['shipping_s2_note'])): ?>
                <p><?= $t['shipping_s2_note'] ?></p>
            <?php endif; ?>

            <ul>
                <?php if (!empty($t['shipping_s2_item2'])): ?><li><?= $t['shipping_s2_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 3 -->
        <?php if (!empty($t['shipping_s3_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s3_title']) ?></h2>
            <p><?= $t['shipping_s3_intro'] ?? '' ?></p>
            <ul>
                <?php if (!empty($t['shipping_s3_item1'])): ?><li><?= $t['shipping_s3_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s3_item2'])): ?><li><?= $t['shipping_s3_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 4 -->
        <?php if (!empty($t['shipping_s4_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s4_title']) ?></h2>
            <ul>
                <?php if (!empty($t['shipping_s4_item1'])): ?><li><?= $t['shipping_s4_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s4_item2'])): ?><li><?= $t['shipping_s4_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 5 -->
        <?php if (!empty($t['shipping_s5_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s5_title']) ?></h2>
            <ul>
                <?php if (!empty($t['shipping_s5_item1'])): ?><li><?= $t['shipping_s5_item1'] ?></li><?php endif; ?>
                <?php if (!empty($t['shipping_s5_item2'])): ?><li><?= $t['shipping_s5_item2'] ?></li><?php endif; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <!-- Section 6 -->
        <?php if (!empty($t['shipping_s6_title'])): ?>
            <h2><?= htmlspecialchars($t['shipping_s6_title']) ?></h2>
            <p><?= $t['shipping_s6_intro'] ?? '' ?></p>
            <ul>
                <?php if (!empty($t['shipping_s6_contact'])): ?>
                    <li><?= $t['shipping_s6_contact'] ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</main>