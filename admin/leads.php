<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/leads.php';
require_once __DIR__ . '/../includes/helpers.php';

adminRequireLogin();

$statuses = leadStatuses();
$viewId = trim((string) ($_GET['id'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');
    $id = trim((string) ($_POST['lead_id'] ?? ''));

    if ($action === 'delete_lead' && $id !== '') {
        if (deleteLead($id)) {
            adminFlash('success', 'Lead deleted.');
        } else {
            adminFlash('error', 'Could not delete lead.');
        }
        header('Location: leads.php');
        exit;
    }

    if ($action === 'save_lead' && $id !== '') {
        $email = trim((string) ($_POST['email'] ?? ''));
        $brand = trim((string) ($_POST['brand_name'] ?? ''));
        $keyword = trim((string) ($_POST['keyword'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $countryCode = preg_replace('/\D+/', '', (string) ($_POST['country_code'] ?? '')) ?? '';
        $dialCodes = countryDialCodes();

        if ($brand === '' || $keyword === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '') {
            adminFlash('error', 'Brand, keyword, valid email, and phone are required.');
            header('Location: leads.php?id=' . rawurlencode($id));
            exit;
        }
        if ($countryCode === '' || !isset($dialCodes[$countryCode])) {
            adminFlash('error', 'Please select a valid country code.');
            header('Location: leads.php?id=' . rawurlencode($id));
            exit;
        }

        $ok = updateLead($id, [
            'brand_name' => $brand,
            'slogan' => trim((string) ($_POST['slogan'] ?? '')),
            'industry' => trim((string) ($_POST['industry'] ?? '')),
            'keyword' => $keyword,
            'email' => $email,
            'country_code' => $countryCode,
            'phone' => $phone,
            'status' => trim((string) ($_POST['status'] ?? 'new')),
            'notes' => trim((string) ($_POST['notes'] ?? '')),
        ]);

        adminFlash($ok ? 'success' : 'error', $ok ? 'Lead saved.' : 'Could not save lead.');
        header('Location: leads.php?id=' . rawurlencode($id));
        exit;
    }

    if ($action === 'update_status' && $id !== '') {
        $lead = getLeadById($id);
        if ($lead && updateLead($id, array_merge($lead, [
            'status' => trim((string) ($_POST['status'] ?? 'new')),
        ]))) {
            adminFlash('success', 'Status updated.');
        } else {
            adminFlash('error', 'Could not update status.');
        }
        $redirect = !empty($_POST['return_view']) ? ('leads.php?id=' . rawurlencode($id)) : 'leads.php';
        header('Location: ' . $redirect);
        exit;
    }
}

$leads = loadLeads();
$flash = adminGetFlash();
$viewLead = $viewId !== '' ? getLeadById($viewId) : null;
$industries = auditIndustries();
$dialCodes = countryDialCodes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $viewLead ? 'View Lead' : 'Leads'; ?> | Admin</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
  <aside class="admin-sidebar">
    <div class="sidebar-brand">Master Control</div>
    <nav class="sidebar-nav">
      <a href="index.php">Content Dashboard</a>
      <a href="leads.php" class="is-active">Leads (<?php echo count($leads); ?>)</a>
    </nav>
    <div class="sidebar-actions">
      <a href="../index.php" target="_blank" class="sidebar-btn">View Site ↗</a>
      <a href="logout.php" class="sidebar-btn muted">Logout</a>
    </div>
  </aside>

  <main class="admin-main admin-main--wide">
    <?php if ($viewLead): ?>
    <div class="admin-topbar">
      <h1>View / Edit Lead</h1>
      <p><a href="leads.php" class="back-inline">← Back to all leads</a></p>
    </div>

    <?php if ($flash): ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
    <?php endif; ?>

    <section class="admin-panel">
      <div class="lead-view-meta">
        <span class="lead-status-badge status-<?php echo e($viewLead['status'] ?? 'new'); ?>">
          <?php echo e($statuses[$viewLead['status'] ?? 'new'] ?? 'New'); ?>
        </span>
        <span class="hint" style="margin:0">
          Created:
          <?php
            $ts = strtotime((string) ($viewLead['created_at'] ?? ''));
            echo e($ts ? date('d M Y, h:i A', $ts) : '—');
          ?>
          <?php if (!empty($viewLead['updated_at'])): ?>
          · Updated:
          <?php
            $uts = strtotime((string) $viewLead['updated_at']);
            echo e($uts ? date('d M Y, h:i A', $uts) : '—');
          ?>
          <?php endif; ?>
        </span>
      </div>

      <form method="post" class="admin-form lead-edit-form">
        <input type="hidden" name="action" value="save_lead">
        <input type="hidden" name="lead_id" value="<?php echo e($viewLead['id']); ?>">

        <div class="grid-2">
          <label>Brand name<input type="text" name="brand_name" required value="<?php echo e($viewLead['brand_name'] ?? ''); ?>"></label>
          <label>Slogan<input type="text" name="slogan" value="<?php echo e($viewLead['slogan'] ?? ''); ?>"></label>
          <label>Industry
            <select name="industry">
              <option value="">—</option>
              <?php foreach ($industries as $industry): ?>
              <option value="<?php echo e($industry); ?>" <?php echo (($viewLead['industry'] ?? '') === $industry) ? 'selected' : ''; ?>>
                <?php echo e($industry); ?>
              </option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Status
            <select name="status" required>
              <?php foreach ($statuses as $key => $label): ?>
              <option value="<?php echo e($key); ?>" <?php echo (($viewLead['status'] ?? 'new') === $key) ? 'selected' : ''; ?>>
                <?php echo e($label); ?>
              </option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Keyword<input type="text" name="keyword" required value="<?php echo e($viewLead['keyword'] ?? ''); ?>"></label>
          <label>Email<input type="email" name="email" required value="<?php echo e($viewLead['email'] ?? ''); ?>"></label>
          <label>Country code
            <select name="country_code" required>
              <?php
                $leadCode = (string) ($viewLead['country_code'] ?? '91');
                if (!isset($dialCodes[$leadCode]) && !isset($dialCodes[(int) $leadCode])) {
                    $leadCode = '91';
                }
                foreach ($dialCodes as $code => $label):
                  $codeStr = (string) $code;
              ?>
              <option value="<?php echo e($codeStr); ?>" <?php echo $leadCode === $codeStr ? 'selected' : ''; ?>>
                <?php echo e($label); ?>
              </option>
              <?php endforeach; ?>
            </select>
          </label>
          <label>Phone<input type="text" name="phone" required value="<?php echo e($viewLead['phone'] ?? ''); ?>"></label>
          <label>Source<input type="text" value="<?php echo e($viewLead['source'] ?? ''); ?>" disabled></label>
        </div>

        <label>Internal notes<textarea name="notes" rows="4" placeholder="Call notes, follow-ups…"><?php echo e($viewLead['notes'] ?? ''); ?></textarea></label>

        <div class="lead-form-actions">
          <button type="submit" class="btn-save">Save Lead</button>
          <button type="submit" class="btn-remove-lead" form="deleteLeadForm" onclick="return confirm('Delete this lead?');">Delete</button>
        </div>
      </form>

      <form id="deleteLeadForm" method="post">
        <input type="hidden" name="action" value="delete_lead">
        <input type="hidden" name="lead_id" value="<?php echo e($viewLead['id']); ?>">
      </form>
    </section>

    <?php else: ?>
    <div class="admin-topbar">
      <h1>Leads</h1>
      <p>Free Audit submissions — view, save, and update status.</p>
    </div>

    <?php if ($flash): ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
    <?php endif; ?>

    <?php if ($viewId !== '' && !$viewLead): ?>
    <div class="alert alert-error">Lead not found.</div>
    <?php endif; ?>

    <section class="admin-panel">
      <h2>All leads (<?php echo count($leads); ?>)</h2>

      <?php if ($leads === []): ?>
      <p class="hint">No leads yet. When someone completes Free Audit, they will show up here.</p>
      <?php else: ?>
      <div class="leads-table-wrap">
        <table class="leads-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Brand</th>
              <th>Status</th>
              <th>Keyword</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($leads as $lead):
              $statusKey = $lead['status'] ?? 'new';
              if (!isset($statuses[$statusKey])) {
                  $statusKey = 'new';
              }
            ?>
            <tr>
              <td><?php
                $ts = strtotime((string) ($lead['created_at'] ?? ''));
                echo e($ts ? date('d M Y, h:i A', $ts) : '—');
              ?></td>
              <td><strong><?php echo e($lead['brand_name'] ?? ''); ?></strong></td>
              <td>
                <form method="post" class="status-inline-form">
                  <input type="hidden" name="action" value="update_status">
                  <input type="hidden" name="lead_id" value="<?php echo e($lead['id'] ?? ''); ?>">
                  <select name="status" class="status-select status-<?php echo e($statusKey); ?>" onchange="this.form.submit()">
                    <?php foreach ($statuses as $key => $label): ?>
                    <option value="<?php echo e($key); ?>" <?php echo $statusKey === $key ? 'selected' : ''; ?>>
                      <?php echo e($label); ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </form>
              </td>
              <td><?php echo e($lead['keyword'] ?? ''); ?></td>
              <td><a href="mailto:<?php echo e($lead['email'] ?? ''); ?>"><?php echo e($lead['email'] ?? ''); ?></a></td>
              <td>
                <?php $tel = leadTelHref($lead); ?>
                <?php if ($tel !== ''): ?>
                <a href="tel:<?php echo e($tel); ?>"><?php echo e(formatLeadPhone($lead)); ?></a>
                <?php else: ?>
                —
                <?php endif; ?>
              </td>
              <td class="leads-actions">
                <a class="btn-view-lead" href="leads.php?id=<?php echo e(rawurlencode((string) ($lead['id'] ?? ''))); ?>">View</a>
                <form method="post" onsubmit="return confirm('Delete this lead?');">
                  <input type="hidden" name="action" value="delete_lead">
                  <input type="hidden" name="lead_id" value="<?php echo e($lead['id'] ?? ''); ?>">
                  <button type="submit" class="btn-remove-lead">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </section>
    <?php endif; ?>
  </main>
</body>
</html>
