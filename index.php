<?php
require_once __DIR__ . '/includes/content.php';

$content = loadSiteContent();
$pageTitle = $content['site']['page_title'] ?? 'Home';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/home-template.php';
require __DIR__ . '/includes/footer.php';
