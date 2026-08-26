<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content.php';
require_once __DIR__ . '/includes/helpers.php';

$content = loadSiteContent();
$social = $content['social'] ?? [];
$waUrl = whatsappUrl(
    $social['whatsapp_number'] ?? ($content['footer_cta']['phone'] ?? ''),
    $social['whatsapp_message'] ?? 'Hi, I would like to know more about your services.'
);

header('Location: ' . ($waUrl !== '' ? $waUrl : 'index.php'));
exit;
