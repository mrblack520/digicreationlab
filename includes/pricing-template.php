<?php
/** @var array $content */
$pricing = $content['pricing'] ?? [];
$currency = $pricing['currency'] ?? '$';
$categories = $pricing['categories'] ?? [];

// Backward compatible: old single plans list
if (empty($categories) && !empty($pricing['plans'])) {
    $categories = [[
        'id' => 'plans',
        'title' => $pricing['title'] ?? 'Pricing',
        'subtitle' => $pricing['subtitle'] ?? '',
        'plans' => $pricing['plans'],
    ]];
}
?>

<main>
  <section class="section pricing-page">
    <div class="pricing-head">
      <p class="eyebrow center"><?php echo e($pricing['eyebrow'] ?? 'Pricing'); ?></p>
      <h1 class="section-title center"><?php echo e($pricing['title'] ?? 'Our packages'); ?></h1>
      <p class="pricing-sub center"><?php echo e($pricing['subtitle'] ?? ''); ?></p>
    </div>

    <?php if (!empty($categories)): ?>
    <nav class="pricing-nav" aria-label="Package types">
      <?php foreach ($categories as $cat): ?>
      <a href="#<?php echo e($cat['id'] ?? ''); ?>" class="pricing-nav-link"><?php echo e($cat['title'] ?? ''); ?></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>

    <?php foreach ($categories as $cat): ?>
    <section class="pricing-category" id="<?php echo e($cat['id'] ?? ''); ?>">
      <div class="pricing-category-head">
        <h2 class="pricing-category-title"><?php echo e($cat['title'] ?? ''); ?></h2>
        <?php if (!empty($cat['subtitle'])): ?>
        <p class="pricing-category-sub"><?php echo e($cat['subtitle']); ?></p>
        <?php endif; ?>
      </div>

      <div class="pricing-grid pricing-grid--<?php echo count($cat['plans'] ?? []) >= 4 ? '4' : '3'; ?>">
        <?php foreach (($cat['plans'] ?? []) as $plan): ?>
        <article class="pricing-card<?php echo !empty($plan['featured']) ? ' is-featured' : ''; ?>">
          <?php if (!empty($plan['badge'])): ?>
          <span class="pricing-badge"><?php echo e($plan['badge']); ?></span>
          <?php endif; ?>

          <h3 class="pricing-name"><?php echo e($plan['name']); ?></h3>
          <?php if (!empty($plan['description'])): ?>
          <p class="pricing-desc"><?php echo e($plan['description']); ?></p>
          <?php endif; ?>

          <div class="pricing-price">
            <?php if (!empty($plan['old_price'])): ?>
            <span class="pricing-old"><?php echo e($currency . $plan['old_price']); ?></span>
            <?php endif; ?>
            <div class="pricing-price-row">
              <?php if (($plan['price'] ?? '') !== 'Custom' && !str_contains((string) ($plan['price'] ?? ''), 'Starting')): ?>
              <span class="pricing-currency"><?php echo e($currency); ?></span>
              <?php endif; ?>
              <span class="pricing-amount"><?php echo e($plan['price']); ?></span>
              <?php if (!empty($plan['period'])): ?>
              <span class="pricing-period"><?php echo e($plan['period']); ?></span>
              <?php endif; ?>
            </div>
          </div>

          <ul class="pricing-features">
            <?php foreach (($plan['features'] ?? []) as $feature): ?>
            <li><?php echo e($feature); ?></li>
            <?php endforeach; ?>
          </ul>

          <a href="<?php echo e($plan['button_url'] ?? 'index.php#contact'); ?>" class="btn <?php echo !empty($plan['featured']) ? 'btn-dark' : 'btn-outline'; ?>">
            <?php echo e($plan['button_text'] ?? 'Order Now'); ?>
            <span class="btn-arrow" aria-hidden="true">→</span>
          </a>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endforeach; ?>
  </section>
</main>
