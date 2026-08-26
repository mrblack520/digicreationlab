<?php
/** @var array $content */
$c = $content;
$site = $c['site'];
$header = $c['header'];
$hero = $c['hero'];
$trust = $c['trust_bar'];
$wwd = $c['what_we_do'];
$cap = $c['capabilities'];
$why = $c['why_section'];
$stories = $c['stories'];
$logos = $c['logos'];
$blog = $c['blog'];
$stats = $c['stats_section'];
$testi = $c['testimonials'];
$fcta = $c['footer_cta'];
$footer = $c['footer'];
$footerNav = parseLinkLines(str_replace(', ', "\n", $footer['nav']));
if (!isset($waUrl)) {
    require_once __DIR__ . '/helpers.php';
    $waUrl = whatsappUrl(
        ($c['social']['whatsapp_number'] ?? '') ?: ($fcta['phone'] ?? ''),
        $c['social']['whatsapp_message'] ?? 'Hi, I would like to know more about your services.'
    );
}
?>

<main>
  <section class="hero" id="audit">
    <div class="hero-copy">
      <h1 class="hero-title"><?php echo e($hero['title']); ?></h1>
      <p class="hero-sub"><?php echo e($hero['subtitle']); ?></p>
    </div>

    <div class="hero-visual">
      <img class="hero-bento-img" src="<?php echo e($hero['hero_image']); ?>" alt="<?php echo e($hero['title']); ?>" width="1100" height="520">
      <a href="<?php echo e($waUrl !== '' ? $waUrl : '#contact'); ?>" class="hero-cta-hit" <?php echo $waUrl !== '' ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> aria-label="Let's Talk on WhatsApp">
        <span class="sr-only">Let's Talk on WhatsApp</span>
      </a>
    </div>

    <div class="trust-bar">
      <div class="trust-inner">
        <a href="<?php echo e($trust['experts_url']); ?>" class="trust-experts">
          <div class="avatars">
            <img src="<?php echo e($trust['avatar_1']); ?>" alt="">
            <img src="<?php echo e($trust['avatar_2']); ?>" alt="">
            <img src="<?php echo e($trust['avatar_3']); ?>" alt="">
          </div>
          <span><?php echo e($trust['experts_text']); ?></span>
        </a>

        <div class="trust-revenue">
          <span class="counter" data-target="<?php echo e($trust['revenue_number']); ?>">0</span>
          <span class="revenue-label"><?php echo titleHtml($trust['revenue_label']); ?></span>
        </div>

        <div class="trust-reviews">
          <div class="stars" aria-label="5 star rating">
            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
          </div>
          <p><span class="counter" data-target="<?php echo e($trust['reviews_count']); ?>">0</span><?php echo e($trust['reviews_suffix']); ?></p>
        </div>
      </div>
    </div>
  </section>

  <section class="section what-we-do" id="about">
    <div class="section-head split">
      <div>
        <p class="eyebrow"><?php echo e($wwd['eyebrow']); ?></p>
        <h2 class="section-title"><?php echo titleHtml($wwd['title']); ?></h2>
      </div>
      <div class="section-intro">
        <p><?php echo e($wwd['intro']); ?></p>
        <a href="<?php echo e($wwd['link_url']); ?>" class="text-link"><?php echo e($wwd['link_text']); ?></a>
      </div>
    </div>

    <div class="cards-3">
      <?php foreach ($wwd['cards'] as $card): ?>
      <article class="service-card">
        <div class="service-card-top">
          <h3><?php echo e($card['title']); ?></h3>
          <span class="icon-badge" aria-hidden="true"><?php echo e($card['icon']); ?></span>
        </div>
        <p><?php echo e($card['text']); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section capabilities" id="capabilities">
    <div class="team-banner">
      <img src="<?php echo e($cap['banner_image']); ?>" alt="<?php echo e($cap['banner_alt']); ?>" loading="lazy">
    </div>

    <div class="capabilities-head">
      <p class="eyebrow"><?php echo e($cap['eyebrow']); ?></p>
      <h2 class="section-title"><?php echo e($cap['title']); ?></h2>
      <a href="<?php echo e($cap['button_url']); ?>" class="btn btn-dark">
        <?php echo e($cap['button_text']); ?>
        <span class="btn-arrow" aria-hidden="true">→</span>
      </a>
    </div>

    <div class="cards-4">
      <?php foreach ($cap['cards'] as $card): ?>
      <article class="cap-card">
        <span class="cap-icon" aria-hidden="true"><?php echo e($card['icon']); ?></span>
        <h3><?php echo e($card['title']); ?></h3>
        <p><?php echo e($card['text']); ?></p>
        <a href="<?php echo e($card['link']); ?>" class="learn-link">Learn more</a>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section why-section">
    <div class="why-grid">
      <div class="tab-panel">
        <div class="tab-list" role="tablist">
          <?php foreach ($why['tabs'] as $i => $tab): ?>
          <button class="tab-btn<?php echo $i === 0 ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" data-tab="<?php echo e($tab['id']); ?>"><?php echo e($tab['label']); ?></button>
          <?php endforeach; ?>
        </div>

        <?php foreach ($why['tabs'] as $i => $tab): ?>
        <div class="tab-content<?php echo $i === 0 ? ' is-active' : ''; ?>" data-panel="<?php echo e($tab['id']); ?>">
          <h3><?php echo e($tab['title']); ?></h3>
          <p><?php echo e($tab['text']); ?></p>
          <?php if (($tab['type'] ?? '') === 'chart'): ?>
          <div class="chart-card">
            <div class="chart-head"><span>Growth</span><span class="chart-select">Monthly ▾</span></div>
            <svg class="growth-chart" viewBox="0 0 320 120" aria-hidden="true">
              <polyline points="20,90 70,75 120,80 170,55 220,45 270,30 300,25" fill="none" stroke="#111" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
              <circle cx="20" cy="90" r="4" fill="#111"/><circle cx="70" cy="75" r="4" fill="#111"/>
              <circle cx="120" cy="80" r="4" fill="#111"/><circle cx="170" cy="55" r="4" fill="#111"/>
              <circle cx="220" cy="45" r="4" fill="#111"/><circle cx="270" cy="30" r="4" fill="#111"/>
              <circle cx="300" cy="25" r="4" fill="#111"/>
            </svg>
            <div class="chart-labels"><span>Jul</span><span>Jun</span><span>Aug</span><span>Sep</span><span>Oct</span></div>
          </div>
          <?php elseif (($tab['type'] ?? '') === 'stats' && !empty($tab['stats'])): ?>
          <div class="expert-stats">
            <?php foreach ($tab['stats'] as $stat): ?>
            <div><strong><?php echo e($stat['value']); ?></strong><span><?php echo e($stat['label']); ?></span></div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="why-copy">
        <h2 class="section-title"><?php echo e($why['side_title']); ?></h2>
        <p><?php echo e($why['side_text']); ?></p>
        <a href="<?php echo e($why['button_url']); ?>" class="btn btn-dark">
          <?php echo e($why['button_text']); ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </section>

  <section class="section stories" id="work">
    <div class="stories-grid">
      <div class="stories-head">
        <p class="eyebrow"><?php echo e($stories['eyebrow']); ?></p>
        <h2 class="section-title"><?php echo titleHtml($stories['title']); ?></h2>
        <a href="<?php echo e($stories['link_url']); ?>" class="text-link"><?php echo e($stories['link_text']); ?></a>
      </div>

      <div class="stories-slider">
        <div class="stories-track">
          <?php foreach ($stories['items'] as $item): ?>
          <article class="story-card" style="--bg:url('<?php echo e($item['image']); ?>')">
            <span class="story-brand"><?php echo e($item['brand']); ?></span>
            <h3><?php echo e($item['result']); ?></h3>
            <div class="story-tags">
              <?php foreach (parseTags($item['tags']) as $tag): ?>
              <span><?php echo e($tag); ?></span>
              <?php endforeach; ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <div class="slider-dots">
          <?php foreach ($stories['items'] as $i => $item): ?>
          <button class="dot<?php echo $i === 0 ? ' is-active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="section logos">
    <p class="logos-title"><?php echo e($logos['title']); ?></p>
    <div class="logo-row">
      <?php foreach ($logos['items'] as $logo): ?>
      <span class="brand-logo<?php echo !empty($logo['class']) ? ' ' . e($logo['class']) : ''; ?>"><?php echo e($logo['text']); ?></span>
      <?php endforeach; ?>
    </div>
    <div class="logo-divider"></div>
  </section>

  <section class="section blog" id="blog">
    <div class="blog-head">
      <p class="eyebrow center"><?php echo e($blog['eyebrow']); ?></p>
      <h2 class="section-title center"><?php echo e($blog['title']); ?></h2>
    </div>
    <div class="cards-3 blog-cards">
      <?php foreach ($blog['posts'] as $post): ?>
      <article class="blog-card">
        <div class="blog-thumb has-img">
          <img src="<?php echo e($post['image']); ?>" alt="" loading="lazy">
        </div>
        <div class="blog-body">
          <time datetime="<?php echo e($post['datetime']); ?>"><?php echo e($post['date']); ?></time>
          <h3><?php echo e($post['title']); ?></h3>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section stats-section">
    <div class="stats-box">
      <h2 class="section-title"><?php echo e($stats['title']); ?></h2>
      <div class="stats-row">
        <?php foreach ($stats['circles'] as $circle): ?>
        <div class="stat-circle">
          <div class="ring"><span class="counter" data-target="<?php echo e($circle['value']); ?>" data-suffix="<?php echo e($circle['suffix']); ?>">0</span></div>
          <p><?php echo e($circle['label']); ?></p>
        </div>
        <?php endforeach; ?>
        <div class="leads-card">
          <span class="leads-num"><span class="counter" data-target="<?php echo e($stats['leads_number']); ?>" data-suffix="<?php echo e($stats['leads_suffix']); ?>">0</span></span>
          <p><?php echo e($stats['leads_text']); ?></p>
          <a href="<?php echo e($stats['leads_url']); ?>" class="btn btn-dark">
            <?php echo e($stats['leads_button']); ?>
            <span class="btn-arrow" aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="section testimonials">
    <div class="testimonial-grid">
      <div class="testimonial-content">
        <span class="quote-mark" aria-hidden="true">"</span>
        <blockquote class="testimonial-slider">
          <?php foreach ($testi['items'] as $i => $item): ?>
          <p class="quote<?php echo $i === 0 ? ' is-active' : ''; ?>" data-name="<?php echo e($item['name']); ?>" data-role="<?php echo e($item['role']); ?>"><?php echo e($item['quote']); ?></p>
          <?php endforeach; ?>
        </blockquote>
        <div class="quote-author">
          <strong class="author-name"><?php echo e($testi['items'][0]['name']); ?></strong>
          <span class="author-role"><?php echo e($testi['items'][0]['role']); ?></span>
        </div>
        <div class="testimonial-nav">
          <button class="t-nav prev" aria-label="Previous testimonial">←</button>
          <button class="t-nav next" aria-label="Next testimonial">→</button>
        </div>
      </div>

      <svg class="testimonial-dash" viewBox="0 0 200 300" fill="none" aria-hidden="true">
        <path d="M160 10 C 120 80, 180 160, 60 280" stroke="#ccc" stroke-width="1.5" stroke-dasharray="4 6" stroke-linecap="round"/>
      </svg>

      <div class="testimonial-meta">
        <div class="trust-reviews">
          <div class="stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
          <p><?php echo e($testi['reviews_text']); ?></p>
        </div>
        <a href="<?php echo e($testi['reviews_link_url']); ?>" class="trust-experts">
          <div class="avatars">
            <img src="<?php echo e($trust['avatar_1']); ?>" alt="">
            <img src="<?php echo e($trust['avatar_2']); ?>" alt="">
            <img src="<?php echo e($trust['avatar_3']); ?>" alt="">
          </div>
          <span><?php echo e($testi['reviews_link_text']); ?></span>
        </a>
      </div>
    </div>
  </section>

  <section class="footer-cta" id="contact">
    <div class="footer-cta-inner">
      <div class="footer-cta-left">
        <h2><?php echo e($fcta['title']); ?></h2>
        <div class="partner-block">
          <p class="eyebrow"><?php echo e($fcta['partner_eyebrow']); ?></p>
          <div class="partner-logos">
            <?php foreach (linesToArray(str_replace(', ', "\n", $fcta['partners'])) as $partner): ?>
            <span><?php echo e($partner); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="footer-cta-right">
        <p class="cta-phone-label"><?php echo e($fcta['phone_label']); ?></p>
        <a href="tel:<?php echo e(preg_replace('/\D+/', '', $fcta['phone'])); ?>" class="phone-num"><?php echo e($fcta['phone']); ?></a>
        <a href="<?php echo e($waUrl !== '' ? $waUrl : ($fcta['button_url'] ?? '#contact')); ?>" class="btn btn-dark" <?php echo $waUrl !== '' ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
          <?php echo e($fcta['button_text']); ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
        <div class="roas-stat">
          <strong><?php echo e($fcta['roas_title']); ?></strong>
          <span><?php echo e($fcta['roas_text']); ?></span>
        </div>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  <div class="footer-inner">
    <p class="eyebrow"><?php echo e($footer['solutions_eyebrow']); ?></p>
    <div class="footer-links">
      <?php foreach (['links_col1', 'links_col2', 'links_col3', 'links_col4'] as $col): ?>
      <div>
        <?php foreach (linesToArray($footer[$col]) as $link): ?>
        <a href="#"><?php echo e($link); ?></a>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <nav class="footer-nav" aria-label="Footer">
      <?php foreach ($footerNav as $link): ?>
      <a href="<?php echo e($link['url']); ?>"><?php echo e($link['label']); ?></a>
      <?php endforeach; ?>
    </nav>

    <?php
    $social = $c['social'] ?? [];
    $ig = $social['instagram'] ?? ($footer['social_instagram'] ?? '#');
    $tt = $social['tiktok'] ?? '#';
    $tw = $social['twitter'] ?? ($footer['social_twitter'] ?? '#');
    $fb = $social['facebook'] ?? ($footer['social_facebook'] ?? '#');
    $yt = $social['youtube'] ?? ($footer['social_youtube'] ?? '#');
    ?>
    <div class="footer-bottom">
      <p>© <?php echo date('Y'); ?> <?php echo e($footer['copyright']); ?>. All rights reserved.
        <a href="<?php echo e($footer['terms_url']); ?>">Terms &amp; Conditions</a>
        <a href="<?php echo e($footer['privacy_url']); ?>">Privacy Policy</a>
      </p>
      <div class="social-icons">
        <?php if ($ig && $ig !== '#'): ?><a href="<?php echo e($ig); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a><?php endif; ?>
        <?php if ($tt && $tt !== '#'): ?><a href="<?php echo e($tt); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">TT</a><?php endif; ?>
        <?php if ($tw && $tw !== '#'): ?><a href="<?php echo e($tw); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">X</a><?php endif; ?>
        <?php if ($fb && $fb !== '#'): ?><a href="<?php echo e($fb); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a><?php endif; ?>
        <?php if ($yt && $yt !== '#'): ?><a href="<?php echo e($yt); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">YT</a><?php endif; ?>
      </div>
    </div>
  </div>
</footer>
