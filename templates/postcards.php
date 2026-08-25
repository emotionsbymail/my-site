<?php
// Определение текущего языка (по умолчанию 'uk')
$lang = $lang ?? 'uk';

// Нормализация ISO-кода (если передан 'ua', используем 'uk' для файлов и роутов)
if ($lang === 'ua') {
    $lang = 'uk';
}

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

// Правильное формирование префикса URL с учетом языковых версий
$url_prefix = '/';
if ($lang === 'ru') {
    $url_prefix = '/ru/';
} elseif ($lang === 'en') {
    $url_prefix = '/en/';
} elseif ($lang === 'uk') {
    // Если для украинского используется префикс, раскомментируйте:
    // $url_prefix = '/uk/';
    $url_prefix = '/';
}

// Получаем локализованную надпись для заглушки
$placeholder_text = htmlspecialchars($texts['img_placeholder'] ?? 'ИЗОБРАЖЕНИЕ ГОТОВИТСЯ');

// Встроенная SVG-заглушка в Data URL с динамическим текстом
$default_svg = 'data:image/svg+xml;utf8,' . rawurlencode('
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600" width="100%" height="100%">
  <defs>
    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#1e293b"/>
      <stop offset="100%" stop-color="#0f172a"/>
    </linearGradient>
    <linearGradient id="cardGrad" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" stop-color="#334155"/>
      <stop offset="100%" stop-color="#1e293b"/>
    </linearGradient>
    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
      <path d="M 20 0 L 0 0 0 20" fill="none" stroke="#ffffff" stroke-opacity="0.03" stroke-width="1"/>
    </pattern>
  </defs>
  <rect width="800" height="600" fill="url(#bgGrad)"/>
  <rect width="800" height="600" fill="url(#grid)"/>
  <g transform="translate(150, 100)">
    <rect x="10" y="10" width="500" height="380" rx="16" fill="#000000" opacity="0.3"/>
    <rect x="0" y="0" width="500" height="380" rx="16" fill="url(#cardGrad)" stroke="#475569" stroke-width="2"/>
    <rect x="16" y="16" width="468" height="348" rx="10" fill="none" stroke="#64748b" stroke-width="2" stroke-dasharray="8 6"/>
    <rect x="380" y="36" width="80" height="96" rx="4" fill="#0f172a" stroke="#22c55e" stroke-width="2"/>
    <text x="420" y="90" font-family="system-ui, sans-serif" font-size="28" fill="#22c55e" text-anchor="middle">💌</text>
    <line x1="40" y1="230" x2="260" y2="230" stroke="#475569" stroke-width="4" stroke-linecap="round"/>
    <line x1="40" y1="260" x2="340" y2="260" stroke="#475569" stroke-width="4" stroke-linecap="round"/>
    <line x1="40" y1="290" x2="200" y2="290" stroke="#475569" stroke-width="4" stroke-linecap="round"/>
    <circle cx="360" cy="110" r="32" fill="none" stroke="#22c55e" stroke-width="2" stroke-opacity="0.4" stroke-dasharray="5 3"/>
    <path d="M 340 110 Q 360 100 380 110" fill="none" stroke="#22c55e" stroke-width="2" opacity="0.5"/>
    <circle cx="160" cy="120" r="45" fill="#0f172a" stroke="#22c55e" stroke-width="2"/>
    <text x="160" y="132" font-family="system-ui, sans-serif" font-size="40" fill="#22c55e" text-anchor="middle">✨</text>
  </g>
  <text x="400" y="530" font-family="system-ui, sans-serif" font-size="20" font-weight="600" fill="#94a3b8" text-anchor="middle" letter-spacing="1">' . $placeholder_text . '</text>
</svg>');

// Фильтр по категории из GET-параметра
$selected_category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'all';

// Получаем список открыток из словаря
$postcards_items = $texts['postcards_items'] ?? [];

// Фильтрация по категории
if (is_array($postcards_items)) {
    $postcards_items = array_filter($postcards_items, function($card) use ($selected_category) {
        return ($selected_category === 'all') || (($card['category'] ?? '') === $selected_category);
    });
}
?>

<div class="container">
    <section class="postcards-section" data-lang="<?= htmlspecialchars($lang) ?>">
        
        <!-- SEO Заголовок -->
        <h1 class="seo-title">
            <?= htmlspecialchars($texts['postcards_h1'] ?? $texts['postcards_title'] ?? 'Готовые бумажные открытки') ?>
        </h1>

        <p class="welcome-subtitle">
            <?= htmlspecialchars($texts['postcards_subtitle'] ?? 'Выберите эстетичное послание с душевным текстом для себя или близкого человека.') ?>
        </p>

        <!-- Выбор категорий в виде брендовых чипов -->
        <div class="category-pills-container">
            <a href="?category=all" 
               class="category-pill <?= $selected_category === 'all' ? 'active' : '' ?>">
                <?= htmlspecialchars($texts['cat_all'] ?? 'Все категории') ?>
            </a>
            <a href="?category=study" 
               class="category-pill <?= $selected_category === 'study' ? 'active' : '' ?>">
                🎓 <?= htmlspecialchars($texts['cat_study'] ?? 'Студентам и для учебы') ?>
            </a>
            <a href="?category=get_well" 
               class="category-pill <?= $selected_category === 'get_well' ? 'active' : '' ?>">
                🩹 <?= htmlspecialchars($texts['cat_get_well'] ?? 'При болезни и восстановлении') ?>
            </a>
            <a href="?category=support" 
               class="category-pill <?= $selected_category === 'support' ? 'active' : '' ?>">
                🕊️ <?= htmlspecialchars($texts['cat_support'] ?? 'При сложных утратах') ?>
            </a>
            <a href="?category=daily_boost" 
               class="category-pill <?= $selected_category === 'daily_boost' ? 'active' : '' ?>">
                ✨ <?= htmlspecialchars($texts['cat_daily_boost'] ?? 'Мотивация на каждый день') ?>
            </a>
        </div>

        <!-- Сетка открыток -->
        <?php if (!empty($postcards_items) && is_array($postcards_items)): ?>
            <div class="postcards-grid">
                <?php foreach ($postcards_items as $card): ?>
                    <?php 
                        // Выбор картинки: если путь не задан, подставляется SVG-заглушка
                        $card_img = !empty($card['image']) ? $card['image'] : $default_svg; 
                    ?>
                    <div class="postcard-card">
                        
                        <!-- Изображение открытки -->
                        <div class="card-image-wrapper">
                            <img src="<?= htmlspecialchars($card_img) ?>" 
                                 alt="<?= htmlspecialchars($card['title'] ?? '') ?>" 
                                 onerror="this.onerror=null; this.src='<?= $default_svg ?>';"
                                 loading="lazy">
                            
                            <?php if (!empty($card['badge'])): ?>
                                <span class="card-badge">
                                    <?= htmlspecialchars($card['badge']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Контент карточки -->
                        <div class="card-body">
                            <div>
                                <h3 class="card-title">
                                    <?= htmlspecialchars($card['title'] ?? '') ?>
                                </h3>
                                <p class="card-subtitle">
                                    <?= htmlspecialchars($card['subtitle'] ?? '') ?>
                                </p>
                                <p class="card-text">
                                    <?= htmlspecialchars($card['text'] ?? '') ?>
                                </p>
                            </div>

<a href="<?= $url_prefix ?>send?id=<?= htmlspecialchars($card['id'] ?? '') ?>" 
   class="promo-main-btn">
    💌 <?= htmlspecialchars($texts['postcards_btn_order'] ?? '') ?>
</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Пустое состояние -->
            <div class="empty-state">
                <p>
                    <?= htmlspecialchars($texts['no_postcards_found'] ?? 'Открытки не найдены') ?>
                </p>
            </div>
        <?php endif; ?>

<!-- Блок призыва к действию (CTA - В разработке) -->
<div class="promo-cta-box">
    <span class="badge-dev">
        <?= htmlspecialchars($texts['badge_coming_soon'] ?? '') ?>
    </span>
    <h4>
        <?= htmlspecialchars($texts['postcards_cta_title'] ?? '') ?>
    </h4>
    <p>
        <?= htmlspecialchars($texts['postcards_cta_desc'] ?? '') ?>
    </p>
    <button type="button" 
            disabled 
            class="btn-disabled" 
            title="<?= htmlspecialchars($texts['feature_in_development'] ?? '') ?>">
        🛠️ <?= htmlspecialchars($texts['create_own_btn_disabled'] ?? '') ?>
    </button>
</div>

    </section>
</div>