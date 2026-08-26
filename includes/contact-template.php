<?php
/** @var array $content */
require_once __DIR__ . '/helpers.php';

$social = $content['social'] ?? [];
$footerCta = $content['footer_cta'] ?? [];

$email = trim((string) ($social['email'] ?? ''));
$phone = trim((string) ($social['phone'] ?? ''));
if ($phone === '') {
    $phone = trim((string) ($footerCta['phone'] ?? ''));
}
$waUrl = whatsappUrl(
    $social['whatsapp_number'] ?? '',
    $social['whatsapp_message'] ?? 'Hi, I would like to know more about your services.'
);
// Chat Us card shows admin "Chat Us Number" (phone); falls back to WhatsApp number
$waDisplay = $phone !== ''
    ? $phone
    : trim((string) ($social['whatsapp_number'] ?? ''));

$instagram = trim((string) ($social['instagram'] ?? ($content['footer']['social_instagram'] ?? '')));
$twitter = trim((string) ($social['twitter'] ?? ($content['footer']['social_twitter'] ?? '')));
$facebook = trim((string) ($social['facebook'] ?? ($content['footer']['social_facebook'] ?? '')));

$hasLink = static function (string $url): bool {
    return $url !== '' && $url !== '#';
};

$primary = [];
if ($email !== '') {
    $primary[] = [
        'key' => 'email',
        'title' => 'Email Us',
        'value' => $email,
        'href' => 'mailto:' . $email,
        'external' => false,
        'note' => "We'll respond within 24 hours",
        'icon' => 'email',
    ];
}
if ($waUrl !== '') {
    $primary[] = [
        'key' => 'whatsapp',
        'title' => 'Chat Us',
        'value' => $waDisplay !== '' ? $waDisplay : 'Chat on WhatsApp',
        'href' => $waUrl,
        'external' => true,
        'note' => 'Mon–Fri, 9AM–6PM',
        'icon' => 'whatsapp',
    ];
}

$socialCards = [];
if ($hasLink($facebook)) {
    $socialCards[] = ['key' => 'facebook', 'label' => 'Facebook', 'href' => $facebook, 'icon' => 'facebook'];
}
if ($hasLink($instagram)) {
    $socialCards[] = ['key' => 'instagram', 'label' => 'Instagram', 'href' => $instagram, 'icon' => 'instagram'];
}
if ($hasLink($twitter)) {
    $socialCards[] = ['key' => 'twitter', 'label' => 'Twitter', 'href' => $twitter, 'icon' => 'twitter'];
}
if ($waUrl !== '') {
    $socialCards[] = ['key' => 'whatsapp', 'label' => 'WhatsApp', 'href' => $waUrl, 'icon' => 'whatsapp'];
}

$icons = [
    'email' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>',
    'whatsapp' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.28-.14-1.64-.81-1.9-.9-.25-.1-.44-.14-.62.14-.18.27-.71.9-.87 1.08-.16.18-.32.2-.6.07-.28-.14-1.17-.43-2.23-1.37-.82-.73-1.38-1.64-1.54-1.92-.16-.27-.02-.42.12-.55.13-.13.28-.32.42-.48.14-.16.18-.27.28-.45.09-.18.05-.34-.02-.48-.07-.14-.62-1.49-.85-2.04-.22-.53-.45-.46-.62-.47h-.53c-.18 0-.48.07-.73.34-.25.27-.96.94-.96 2.3s.98 2.67 1.12 2.85c.14.18 1.93 2.95 4.68 4.13.65.28 1.16.45 1.56.57.65.2 1.25.18 1.72.11.52-.08 1.64-.67 1.87-1.32.23-.65.23-1.2.16-1.32-.07-.11-.25-.18-.53-.32z"/><path d="M12.04 2C6.5 2 2 6.48 2 12c0 1.77.47 3.5 1.36 5.02L2 22l5.12-1.34A9.96 9.96 0 0 0 12.04 22C17.56 22 22 17.52 22 12S17.56 2 12.04 2zm0 18.2c-1.6 0-3.16-.43-4.52-1.24l-.32-.19-3.04.8.81-2.96-.21-.34A8.17 8.17 0 0 1 3.8 12c0-4.54 3.7-8.23 8.24-8.23 4.54 0 8.23 3.69 8.23 8.23 0 4.54-3.69 8.2-8.23 8.2z"/></svg>',
    'facebook' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-1.9 0-3.5 1.6-3.5 3.5V12H8v3h2.5v7h3v-7H16l.5-3h-3v-2c0-.6.4-1 1-1z"/></svg>',
    'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/></svg>',
    'twitter' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 3H21.5l-7.09 8.1L22.5 21h-6.09l-4.76-5.73L6.5 21H3.24l7.58-8.66L1.5 3h6.24l4.3 5.25L18.244 3zm-1.07 16.2h1.69L7.01 4.7H5.2l11.974 14.5z"/></svg>',
];
?>

<main class="contact-page">
  <section class="section contact-hero">
    <h1 class="contact-title">Get in Touch</h1>
    <p class="contact-lead">We'd love to hear from you. Reach out to us through any of the channels below.</p>
  </section>

  <section class="section contact-body">
    <?php if ($primary === [] && $socialCards === []): ?>
    <p class="contact-empty center">Contact details coming soon. Please check back shortly.</p>
    <?php else: ?>

    <?php if ($primary !== []): ?>
    <div class="contact-primary">
      <?php foreach ($primary as $card): ?>
      <a
        class="contact-primary-card contact-primary-card--<?php echo e($card['key']); ?>"
        href="<?php echo e($card['href']); ?>"
        <?php echo !empty($card['external']) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
      >
        <span class="contact-primary-icon"><?php echo $icons[$card['icon']]; ?></span>
        <span class="contact-primary-title"><?php echo e($card['title']); ?></span>
        <span class="contact-primary-value"><?php echo e($card['value']); ?></span>
        <span class="contact-primary-note"><?php echo e($card['note']); ?></span>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($socialCards !== []): ?>
    <div class="contact-follow">
      <h2 class="contact-follow-title">Follow Us</h2>
      <p class="contact-follow-lead">Stay connected with us on social media</p>
      <div class="contact-social-grid">
        <?php foreach ($socialCards as $card): ?>
        <a
          class="contact-social-card contact-social-card--<?php echo e($card['key']); ?>"
          href="<?php echo e($card['href']); ?>"
          target="_blank"
          rel="noopener noreferrer"
        >
          <span class="contact-social-icon"><?php echo $icons[$card['icon']]; ?></span>
          <span class="contact-social-label"><?php echo e($card['label']); ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php endif; ?>
  </section>
</main>
