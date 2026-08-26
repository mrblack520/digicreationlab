<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/content.php';
require_once __DIR__ . '/includes/leads.php';
require_once __DIR__ . '/includes/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$content = loadSiteContent();
$pageTitle = 'Free Audit';
$industries = auditIndustries();
$dialCodes = countryDialCodes();
$error = $_SESSION['lead_error'] ?? '';
$draft = $_SESSION['lead_draft'] ?? [];
unset($_SESSION['lead_error']);

$_SESSION['lead_csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['lead_csrf'];
$selectedCode = (string) ($draft['country_code'] ?? '91');
if (!isset($dialCodes[$selectedCode])) {
    $selectedCode = '91';
}

require __DIR__ . '/includes/header.php';
?>

<main class="audit-page">
  <section class="audit-shell">
    <p class="eyebrow center">Free marketing audit</p>
    <h1 class="section-title center audit-heading">Tell us about your brand</h1>
    <p class="audit-lead">A few quick details and we???ll prepare your free audit path.</p>

    <?php if ($error !== ''): ?>
    <div class="audit-alert" role="alert"><?php echo e($error); ?></div>
    <?php endif; ?>

    <div class="audit-progress" aria-hidden="true">
      <span class="audit-progress-bar" id="auditProgressBar"></span>
    </div>
    <p class="audit-step-label" id="auditStepLabel">Step 1 of 6</p>

    <form class="audit-form" id="auditForm" action="submit-lead.php" method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?php echo e($csrf); ?>">

      <div class="audit-step is-active" data-step="1">
        <label class="audit-label" for="brand_name">Brand name <span>*</span></label>
        <input class="audit-input" type="text" id="brand_name" name="brand_name" required maxlength="120"
          value="<?php echo e($draft['brand_name'] ?? ''); ?>" placeholder="e.g. Digi Creation" autocomplete="organization">
        <p class="audit-hint">What should we call your business?</p>
      </div>

      <div class="audit-step" data-step="2">
        <label class="audit-label" for="slogan">Slogan <em>(optional)</em></label>
        <input class="audit-input" type="text" id="slogan" name="slogan" maxlength="160"
          value="<?php echo e($draft['slogan'] ?? ''); ?>" placeholder="Your brand tagline">
        <p class="audit-hint">Skip if you don???t have one yet.</p>
      </div>

      <div class="audit-step" data-step="3">
        <label class="audit-label" for="industry">Industry <em>(optional)</em></label>
        <select class="audit-input" id="industry" name="industry">
          <option value="">Select industry</option>
          <?php foreach ($industries as $industry): ?>
          <option value="<?php echo e($industry); ?>" <?php echo (($draft['industry'] ?? '') === $industry) ? 'selected' : ''; ?>>
            <?php echo e($industry); ?>
          </option>
          <?php endforeach; ?>
        </select>
        <p class="audit-hint">Helps us tailor recommendations.</p>
      </div>

      <div class="audit-step" data-step="4">
        <label class="audit-label" for="keyword">Main keyword <span>*</span></label>
        <input class="audit-input" type="text" id="keyword" name="keyword" required maxlength="120"
          value="<?php echo e($draft['keyword'] ?? ''); ?>" placeholder="e.g. digital marketing agency">
        <p class="audit-hint">The phrase you want to rank or advertise for.</p>
      </div>

      <div class="audit-step" data-step="5">
        <label class="audit-label" for="email">Your email <span>*</span></label>
        <input class="audit-input" type="email" id="email" name="email" required maxlength="160"
          value="<?php echo e($draft['email'] ?? ''); ?>" placeholder="you@company.com" autocomplete="email">
      </div>

      <div class="audit-step" data-step="6">
        <label class="audit-label" for="phone">Phone number <span>*</span></label>
        <div class="audit-phone-row">
          <select class="audit-input audit-country" id="country_code" name="country_code" required aria-label="Country code">
            <?php foreach ($dialCodes as $code => $label): ?>
            <option value="<?php echo e((string) $code); ?>" <?php echo $selectedCode === (string) $code ? 'selected' : ''; ?>>
              <?php echo e($label); ?>
            </option>
            <?php endforeach; ?>
          </select>
          <input class="audit-input audit-phone" type="tel" id="phone" name="phone" required maxlength="20"
            value="<?php echo e($draft['phone'] ?? ''); ?>" placeholder="98765 43210" autocomplete="tel-national" inputmode="tel">
        </div>
        <p class="audit-hint">Select your country code, then enter your number.</p>
      </div>

      <div class="audit-actions">
        <button type="button" class="btn btn-outline" id="auditBack" hidden>Back</button>
        <button type="button" class="btn btn-dark" id="auditPrimary">
          <span id="auditPrimaryLabel">Continue</span>
          <span class="btn-arrow" aria-hidden="true">???</span>
        </button>
      </div>
    </form>
  </section>
</main>

<script src="assets/js/free-audit.js?v=<?php echo @filemtime(__DIR__ . '/assets/js/free-audit.js') ?: time(); ?>"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
