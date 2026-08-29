<section class="welcome-section">
    <p class="seo-title"><?= $texts['digital_seo_title'] ?? '' ?></p>
    <h1 class="greeting-text"><?= $texts['digital_title'] ?? '' ?></h1>
    <p class="welcome-subtitle"><?= htmlspecialchars($texts['digital_desc'] ?? '') ?></p>

    <!-- Блок с выбором эмоций -->
    <?php if (!empty($texts['emotions_list'])): ?>
        <div class="emotions-wrapper">
            <h3 class="emotions-heading"><?= htmlspecialchars($texts['emotions_heading'] ?? '') ?></h3>
            
            <div class="emotions-grid">
                <!-- Основные эмоции -->
                <?php foreach ($texts['emotions_list'] as $item): ?>
                    <?php 
                        $subject = rawurlencode($item['subject']);
                        $body = rawurlencode($item['body']);
                        $mailto = "mailto:digital@emotionsbymail.com?subject={$subject}&body={$body}";
                    ?>
                    <a href="<?= $mailto ?>" class="emotion-btn emotion-<?= $item['type'] ?>">
                        <span class="emotion-icon"><?= $item['icon'] ?></span>
                        <span class="emotion-label"><?= htmlspecialchars($item['name']) ?></span>
                    </a>
                <?php endforeach; ?>

                <!-- "Важко визначити" в обычной белой карточке -->
                <?php if (isset($texts['emotion_neutral'])): ?>
                    <?php 
                        $neutral_subject = rawurlencode($texts['neutral_subject'] ?? '');
                        $neutral_body = rawurlencode($texts['neutral_body'] ?? '');
                        $neutral_mailto = "mailto:digital@emotionsbymail.com?subject={$neutral_subject}&body={$neutral_body}";
                    ?>
                    <a href="<?= $neutral_mailto ?>" class="emotion-btn">
                        <span class="emotion-icon">🌀</span>
                        <span class="emotion-label"><?= htmlspecialchars($texts['emotion_neutral']) ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- "Хочу просто выговориться" на 3-х языках (БЕЗ АНИМАЦИИ) -->
            <div class="neutral-emotion-container">
                <?php 
                    $vent_label   = $texts['btn_just_vent'] ?? '';
                    $vent_subject = rawurlencode($texts['vent_subject'] ?? $vent_label);
                    $vent_body    = rawurlencode($texts['vent_body'] ?? '');
                    $vent_mailto  = "mailto:?subject={$vent_subject}&body={$vent_body}";
                ?>
                <a href="<?= $vent_mailto ?>" class="emotion-btn emotion-neutral no-anim" style="text-decoration: none;">
                    <span class="emotion-icon">🌱</span>
                    <span class="emotion-label"><?= htmlspecialchars($vent_label) ?></span>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Подсказка если mailto не сработал -->
    <div class="copy-fallback-block">
        <p class="fallback-text"><?= htmlspecialchars($texts['fallback_text'] ?? '') ?></p>
        <p class="fallback-email-display">digital@emotionsbymail.com</p>
    </div>

    <!-- Кнопка действия -->
    <div class="buttons-container" style="margin-top: 20px;">
        <button type="button" class="btn btn-copy" onclick="copyEmailToClipboard('digital@emotionsbymail.com')">
            📋 <?= htmlspecialchars($texts['btn_copy_email'] ?? '') ?>
        </button>
    </div>
</section>

<section class="formats-section">
  <h2 class="section-title"><?= htmlspecialchars($texts['formats_title'] ?? '') ?></h2>
  <p class="section-subtitle"><?= htmlspecialchars($texts['formats_subtitle'] ?? '') ?></p>

  <div class="cards-grid">
    <!-- Карточка 1: Самопознание -->
    <div class="format-card">
      <div class="card-header">
        <h3><?= htmlspecialchars($texts['col_free'] ?? '') ?></h3>
        <span class="badge free"><?= htmlspecialchars($texts['row_price_free'] ?? '') ?></span>
      </div>
      <div class="card-body">
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_target'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_target_free'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_process'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_process_free'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_time'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_time_free'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_format'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_format_free'] ?? '') ?></p>
        </div>
      </div>
      <div class="card-footer">
        <?php 
            $self_subject = rawurlencode($texts['vent_subject'] ?? '');
            $self_body    = rawurlencode($texts['vent_body'] ?? '');
            $self_mailto  = "mailto:?subject={$self_subject}&body={$self_body}";
        ?>
        <a href="<?= $self_mailto ?>" class="btn btn-outline btn-full">
          <?= htmlspecialchars($texts['btn_start_free'] ?? '') ?>
        </a>
      </div>
    </div>

    <!-- Карточка 2: Живой специалист -->
    <div class="format-card highlight">
      <div class="card-header">
        <h3><?= htmlspecialchars($texts['col_human'] ?? '') ?></h3>
        <span class="badge paid"><?= $texts['row_price_human'] ?? '' ?></span>
      </div>
      <div class="card-body">
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_target'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_target_human'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_process'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_process_human'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_time'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_time_human'] ?? '') ?></p>
        </div>
        <div class="card-item">
          <span class="item-label"><?= htmlspecialchars($texts['lbl_format'] ?? '') ?></span>
          <p><?= htmlspecialchars($texts['row_format_human'] ?? '') ?></p>
        </div>
      </div>
      <div class="card-footer">
        <a href="/<?= htmlspecialchars($lang ?? 'uk') ?>/payment" class="btn btn-primary btn-full">
          <?= $texts['btn_buy_human'] ?? '' ?>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="faq-section">
    <h2 class="faq-title"><?= htmlspecialchars($texts['faq_title'] ?? '') ?></h2>
    
    <div class="faq-accordion">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <?php if (!empty($texts["faq_q{$i}"])): ?>
                <details class="faq-item">
                    <summary class="faq-question">
                        <span><?= htmlspecialchars($texts["faq_q{$i}"]) ?></span>
                        <span class="faq-icon">❯</span>
                    </summary>
                    <div class="faq-answer">
                        <p><?= $texts["faq_a{$i}"] ?></p>
                    </div>
                </details>
            <?php endif; ?>
        <?php endfor; ?>
    </div>
</section>

<!-- Модальный оверлей с центральным уведомлением -->
<div id="copyOverlay" class="copy-overlay">
    <div class="copy-modal">
        <div class="copy-icon">✨</div>
        <div class="copy-message">
            <?= htmlspecialchars($texts['toast_copied'] ?? '') ?>
        </div>
    </div>
</div>