<?php
require_once __DIR__ . '/includes/content.php';
require_once __DIR__ . '/includes/helpers.php';

$content = loadSiteContent();
$pageTitle = 'Contact';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/contact-template.php';
require __DIR__ . '/includes/footer.php';
