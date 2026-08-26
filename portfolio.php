<?php
require_once __DIR__ . '/includes/content.php';

$content = loadSiteContent();
$pageTitle = $content['portfolio']['page_title'] ?? 'Portfolio';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/portfolio-template.php';
require __DIR__ . '/includes/footer.php';
