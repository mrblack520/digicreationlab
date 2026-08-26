<?php
/** @var array $content */
$p = $content['portfolio'] ?? [];
$logos = $p['logos'] ?? [];
$websites = $p['websites'] ?? [];
$activeTab = $_GET['tab'] ?? 'logo';
if (!in_array($activeTab, ['logo', 'website'], true)) {
    $activeTab = 'logo';
}
?>

<main class="portfolio-page">
  <section class="portfolio-hero portfolio-hero--clean">
    <p class="eyebrow center">Portfolio</p>
    <h1 class="section-title center"><?php echo e($p['hero_title'] ?? 'Our creative portfolio'); ?></h1>
    <?php if (!empty($p['hero_subtitle'])): ?>
    <p class="portfolio-lead center"><?php echo e($p['hero_subtitle']); ?></p>
    <?php endif; ?>

    <?php if (!empty($p['hero_image'])): ?>
    <div class="portfolio-hero-media">
      <img
        src="<?php echo e($p['hero_image']); ?>"
        alt="<?php echo e($p['hero_title'] ?? 'Portfolio'); ?>"
        width="1100"
        height="420"
      >
    </div>
    <?php endif; ?>

    <div class="portfolio-tabs" role="tablist" aria-label="Portfolio categories">
      <button
        type="button"
        class="portfolio-tab<?php echo $activeTab === 'logo' ? ' is-active' : ''; ?>"
        role="tab"
        aria-selected="<?php echo $activeTab === 'logo' ? 'true' : 'false'; ?>"
        data-portfolio-tab="logo"
      >Logo</button>
      <button
        type="button"
        class="portfolio-tab<?php echo $activeTab === 'website' ? ' is-active' : ''; ?>"
        role="tab"
        aria-selected="<?php echo $activeTab === 'website' ? 'true' : 'false'; ?>"
        data-portfolio-tab="website"
      >Website</button>
    </div>
  </section>

  <section class="section portfolio-gallery">
    <div
      class="portfolio-panel<?php echo $activeTab === 'logo' ? ' is-active' : ''; ?>"
      data-portfolio-panel="logo"
      role="tabpanel"
    >
      <?php if (empty($logos)): ?>
      <p class="portfolio-empty">No logo projects uploaded yet.</p>
      <?php else: ?>
      <div class="portfolio-grid portfolio-grid--logos">
        <?php foreach ($logos as $item): ?>
          <?php if (empty($item['image'])) continue; ?>
          <article class="portfolio-card portfolio-card--logo">
            <div class="portfolio-card-media">
              <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['title'] ?? 'Logo'); ?>" loading="lazy">
            </div>
            <?php if (!empty($item['title'])): ?>
            <h3 class="portfolio-card-title"><?php echo e($item['title']); ?></h3>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>

    <div
      class="portfolio-panel<?php echo $activeTab === 'website' ? ' is-active' : ''; ?>"
      data-portfolio-panel="website"
      role="tabpanel"
    >
      <?php if (empty($websites)): ?>
      <p class="portfolio-empty">No website projects uploaded yet.</p>
      <?php else: ?>
      <div class="portfolio-grid portfolio-grid--websites">
        <?php foreach ($websites as $item): ?>
          <?php if (empty($item['image'])) continue; ?>
          <article class="portfolio-card portfolio-card--website">
            <?php if (!empty($item['url']) && $item['url'] !== '#'): ?>
            <a href="<?php echo e($item['url']); ?>" class="portfolio-card-media" target="_blank" rel="noopener noreferrer">
              <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['title'] ?? 'Website'); ?>" loading="lazy">
            </a>
            <?php else: ?>
            <div class="portfolio-card-media">
              <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['title'] ?? 'Website'); ?>" loading="lazy">
            </div>
            <?php endif; ?>
            <?php if (!empty($item['title'])): ?>
            <h3 class="portfolio-card-title"><?php echo e($item['title']); ?></h3>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </section>
</main>
