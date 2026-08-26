<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/leads.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: free-audit.php');
    exit;
}

$token = (string) ($_POST['csrf_token'] ?? '');
$sessionToken = (string) ($_SESSION['lead_csrf'] ?? '');
if ($token === '' || $sessionToken === '' || !hash_equals($sessionToken, $token)) {
    $_SESSION['lead_error'] = 'Something went wrong. Please try again.';
    header('Location: free-audit.php');
    exit;
}

$brandName = trim((string) ($_POST['brand_name'] ?? ''));
$slogan = trim((string) ($_POST['slogan'] ?? ''));
$industry = trim((string) ($_POST['industry'] ?? ''));
$keyword = trim((string) ($_POST['keyword'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$countryCode = preg_replace('/\D+/', '', (string) ($_POST['country_code'] ?? '')) ?? '';
$phone = preg_replace('/[^\d\-\s()]/', '', (string) ($_POST['phone'] ?? '')) ?? '';
$phone = trim($phone);
$dialCodes = countryDialCodes();

$errors = [];
if ($brandName === '') {
    $errors[] = 'Brand name is required.';
}
if ($keyword === '') {
    $errors[] = 'Keyword is required.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email is required.';
}
if ($countryCode === '' || !isset($dialCodes[$countryCode])) {
    $errors[] = 'Please select a country code.';
}
if ($phone === '' || strlen(preg_replace('/\D+/', '', $phone) ?? '') < 7) {
    $errors[] = 'A valid phone number is required.';
}
if ($industry !== '' && !in_array($industry, auditIndustries(), true)) {
    $errors[] = 'Please choose a valid industry.';
}

if ($errors !== []) {
    $_SESSION['lead_error'] = implode(' ', $errors);
    $_SESSION['lead_draft'] = [
        'brand_name' => $brandName,
        'slogan' => $slogan,
        'industry' => $industry,
        'keyword' => $keyword,
        'email' => $email,
        'country_code' => $countryCode,
        'phone' => $phone,
    ];
    header('Location: free-audit.php');
    exit;
}

$lead = createLead([
    'brand_name' => $brandName,
    'slogan' => $slogan,
    'industry' => $industry,
    'keyword' => $keyword,
    'email' => $email,
    'country_code' => $countryCode,
    'phone' => $phone,
    'source' => 'free-audit',
]);

if (!addLead($lead)) {
    $_SESSION['lead_error'] = 'Could not save your details. Please try again.';
    header('Location: free-audit.php');
    exit;
}

unset($_SESSION['lead_error'], $_SESSION['lead_draft'], $_SESSION['lead_csrf']);
$_SESSION['lead_thanks'] = true;
$_SESSION['lead_brand'] = $brandName;

header('Location: thank-you.php');
exit;
