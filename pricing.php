<?php
require_once __DIR__ . '/includes/content.php';

$content = loadSiteContent();
$pageTitle = $content['pricing']['page_title'] ?? 'Pricing';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/pricing-template.php';
require __DIR__ . '/includes/footer.php';
