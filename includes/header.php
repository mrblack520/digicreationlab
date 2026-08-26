<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($pageTitle ?? 'Home'); ?> | <?php echo e($content['site']['brand_name'] ?? 'NUMÉRIQUE'); ?></title>
  <?php if (!empty($content['site']['favicon'])): ?>
  <link rel="icon" href="<?php echo e($content['site']['favicon']); ?>" type="image/png">
  <link rel="shortcut icon" href="<?php echo e($content['site']['favicon']); ?>">
  <link rel="apple-touch-icon" href="<?php echo e($content['site']['favicon']); ?>">
  <?php endif; ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/style.css') ?: time(); ?>">
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <a href="index.php" class="logo">
        <?php if (!empty($content['site']['logo_image'])): ?>
        <img class="logo-img" src="<?php echo e($content['site']['logo_image']); ?>" alt="<?php echo e($content['site']['brand_name'] ?? 'Logo'); ?>">
        <?php else: ?>
        <span class="logo-mark"><?php echo e($content['site']['logo_mark'] ?? 'N'); ?></span>
        <?php endif; ?>
        <span class="logo-text"><?php echo e($content['site']['brand_name'] ?? 'NUMÉRIQUE'); ?></span>
      </a>

      <nav class="nav" aria-label="Primary">
        <?php
        $navLinks = $content['header']['nav_links'] ?? [
            ['label' => $content['header']['nav_label'] ?? 'Contact', 'url' => $content['header']['nav_url'] ?? '#contact'],
        ];
        $callNow = null;
        $mainNavLinks = [];
        foreach ($navLinks as $link) {
            $label = trim((string) ($link['label'] ?? ''));
            $url = trim((string) ($link['url'] ?? ''));
            $isCallNow = str_starts_with(strtolower($url), 'tel:')
                || strcasecmp($label, 'Call Now') === 0;
            if ($isCallNow && $callNow === null) {
                $callNow = ['label' => $label !== '' ? $label : 'Call Now', 'url' => $url !== '' ? $url : '#'];
                continue;
            }
            $mainNavLinks[] = $link;
        }
        foreach ($mainNavLinks as $link):
            $linkUrl = $link['url'] ?? '#';
            $isActive = false;
            if (str_contains($linkUrl, 'pricing.php') && basename($_SERVER['PHP_SELF'] ?? '') === 'pricing.php') {
                $isActive = true;
            }
            if (str_contains($linkUrl, 'portfolio.php') && basename($_SERVER['PHP_SELF'] ?? '') === 'portfolio.php') {
                $isActive = true;
            }
        ?>
        <a href="<?php echo e($linkUrl); ?>" class="nav-link<?php echo $isActive ? ' is-active' : ''; ?>"><?php echo e($link['label']); ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="header-actions">
        <a href="free-audit.php" class="btn btn-dark btn-header">
          <?php echo e($content['header']['cta_text'] ?? 'Free Audit'); ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
        <?php if ($callNow): ?>
        <a href="<?php echo e($callNow['url']); ?>" class="btn btn-outline btn-header btn-call-now">
          <?php echo e($callNow['label']); ?>
        </a>
        <?php endif; ?>
      </div>

      <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false">
        <span></span><span></span>
      </button>
    </div>
  </header>
