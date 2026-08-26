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
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/style.css') ?: time(); ?>">
</head>
<body>
  <?php
  require_once __DIR__ . '/helpers.php';
  $social = $content['social'] ?? [];
  $waUrl = whatsappUrl(
      $social['whatsapp_number'] ?? ($content['footer_cta']['phone'] ?? ''),
      $social['whatsapp_message'] ?? 'Hi, I would like to know more about your services.'
  );
  ?>
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
            ['label' => $content['header']['nav_label'] ?? 'Contact', 'url' => $content['header']['nav_url'] ?? 'contact.php'],
        ];
        $callNowLabel = 'Call Now';
        $mainNavLinks = [];
        $hasContactNav = false;
        foreach ($navLinks as $link) {
            $label = trim((string) ($link['label'] ?? ''));
            $url = trim((string) ($link['url'] ?? ''));
            $isCallNow = str_starts_with(strtolower($url), 'tel:')
                || strcasecmp($label, 'Call Now') === 0;
            if ($isCallNow) {
                if ($label !== '') {
                    $callNowLabel = $label;
                }
                continue;
            }
            if (strcasecmp($label, 'Contact') === 0 || str_contains(strtolower($url), 'contact.php')) {
                $hasContactNav = true;
            }
            $mainNavLinks[] = $link;
        }
        if (!$hasContactNav) {
            $mainNavLinks[] = ['label' => 'Contact', 'url' => 'contact.php'];
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
            if (str_contains($linkUrl, 'contact.php') && basename($_SERVER['PHP_SELF'] ?? '') === 'contact.php') {
                $isActive = true;
            }
        ?>
        <a href="<?php echo e($linkUrl); ?>" class="nav-link<?php echo $isActive ? ' is-active' : ''; ?>"><?php echo e($link['label']); ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="header-actions">
        <?php if ($waUrl !== ''): ?>
        <a href="<?php echo e($waUrl); ?>" class="btn btn-dark btn-header btn-call-now" target="_blank" rel="noopener noreferrer">
          <?php echo e($callNowLabel); ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
        <?php else: ?>
        <a href="#contact" class="btn btn-dark btn-header btn-call-now">
          <?php echo e($callNowLabel); ?>
          <span class="btn-arrow" aria-hidden="true">→</span>
        </a>
        <?php endif; ?>
      </div>

      <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false">
        <span></span><span></span>
      </button>
    </div>
  </header>
