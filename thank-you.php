<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content.php';
require_once __DIR__ . '/includes/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['lead_thanks'])) {
    header('Location: free-audit.php');
    exit;
}

$content = loadSiteContent();
$pageTitle = 'Thank You';
$brand = (string) ($_SESSION['lead_brand'] ?? '');
unset($_SESSION['lead_thanks'], $_SESSION['lead_brand']);

require __DIR__ . '/includes/header.php';
?>

<main class="audit-page thankyou-page">
  <section class="audit-shell thankyou-shell">
    <p class="eyebrow center">You’re all set</p>
    <h1 class="section-title center thankyou-title">Thank you<?php echo $brand !== '' ? ', ' . e($brand) : ''; ?> ☺</h1>
    <p class="audit-lead thankyou-copy">
      Checkout our <a href="portfolio.php">Portfolio</a>
      or view our <a href="pricing.php">Pricing and Packages</a>.
    </p>

    <div class="thankyou-actions">
      <a class="btn btn-dark" href="portfolio.php">Checkout Portfolio <span class="btn-arrow">→</span></a>
      <a class="btn btn-outline" href="pricing.php">View Pricing &amp; Packages</a>
    </div>
  </section>
</main>

<div class="lead-modal" id="leadModal" role="dialog" aria-modal="true" aria-labelledby="leadModalTitle" hidden>
  <div class="lead-modal-backdrop" data-close-modal></div>
  <div class="lead-modal-card">
    <button type="button" class="lead-modal-close" data-close-modal aria-label="Close">×</button>
    <p class="eyebrow">Where next?</p>
    <h2 id="leadModalTitle">Choose your next step</h2>
    <p class="lead-modal-text">Visit our portfolio work, or explore pricing packages that fit your brand.</p>
    <div class="lead-modal-actions">
      <a class="btn btn-dark" href="portfolio.php">Visit Portfolio <span class="btn-arrow">→</span></a>
      <a class="btn btn-outline" href="pricing.php">View Pricing Packages</a>
    </div>
  </div>
</div>

<script src="assets/js/thank-you.js?v=<?php echo @filemtime(__DIR__ . '/assets/js/thank-you.js') ?: time(); ?>"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
