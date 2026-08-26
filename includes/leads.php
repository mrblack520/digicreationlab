<?php

declare(strict_types=1);

function leadsFilePath(): string
{
    return __DIR__ . '/../data/leads.json';
}

function loadLeads(): array
{
    $path = leadsFilePath();
    if (!is_file($path)) {
        return [];
    }

    $raw = file_get_contents($path);
    if ($raw === false || trim($raw) === '') {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function saveLeads(array $leads): bool
{
    $path = leadsFilePath();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $json = json_encode(array_values($leads), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    return file_put_contents($path, $json . "\n", LOCK_EX) !== false;
}

function leadStatuses(): array
{
    return [
        'new' => 'New',
        'contacted' => 'Contacted',
        'in_progress' => 'In Progress',
        'won' => 'Won',
        'lost' => 'Lost',
    ];
}

function createLead(array $input): array
{
    return [
        'id' => bin2hex(random_bytes(8)),
        'brand_name' => trim((string) ($input['brand_name'] ?? '')),
        'slogan' => trim((string) ($input['slogan'] ?? '')),
        'industry' => trim((string) ($input['industry'] ?? '')),
        'keyword' => trim((string) ($input['keyword'] ?? '')),
        'email' => trim((string) ($input['email'] ?? '')),
        'country_code' => trim((string) ($input['country_code'] ?? '91')),
        'phone' => trim((string) ($input['phone'] ?? '')),
        'source' => trim((string) ($input['source'] ?? 'free-audit')),
        'status' => 'new',
        'notes' => '',
        'created_at' => date('c'),
        'updated_at' => date('c'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ];
}

function addLead(array $lead): bool
{
    $leads = loadLeads();
    array_unshift($leads, $lead);
    return saveLeads($leads);
}

function getLeadById(string $id): ?array
{
    foreach (loadLeads() as $lead) {
        if (($lead['id'] ?? '') === $id) {
            if (!isset($lead['status']) || $lead['status'] === '') {
                $lead['status'] = 'new';
            }
            if (!isset($lead['notes'])) {
                $lead['notes'] = '';
            }
            return $lead;
        }
    }
    return null;
}

function updateLead(string $id, array $data): bool
{
    $leads = loadLeads();
    $found = false;
    $statuses = array_keys(leadStatuses());

    foreach ($leads as $i => $lead) {
        if (($lead['id'] ?? '') !== $id) {
            continue;
        }

        $status = trim((string) ($data['status'] ?? ($lead['status'] ?? 'new')));
        if (!in_array($status, $statuses, true)) {
            $status = 'new';
        }

        $leads[$i] = array_merge($lead, [
            'brand_name' => trim((string) ($data['brand_name'] ?? $lead['brand_name'] ?? '')),
            'slogan' => trim((string) ($data['slogan'] ?? $lead['slogan'] ?? '')),
            'industry' => trim((string) ($data['industry'] ?? $lead['industry'] ?? '')),
            'keyword' => trim((string) ($data['keyword'] ?? $lead['keyword'] ?? '')),
            'email' => trim((string) ($data['email'] ?? $lead['email'] ?? '')),
            'country_code' => trim((string) ($data['country_code'] ?? $lead['country_code'] ?? '91')),
            'phone' => trim((string) ($data['phone'] ?? $lead['phone'] ?? '')),
            'status' => $status,
            'notes' => trim((string) ($data['notes'] ?? $lead['notes'] ?? '')),
            'updated_at' => date('c'),
        ]);
        $found = true;
        break;
    }

    return $found ? saveLeads($leads) : false;
}

function deleteLead(string $id): bool
{
    $leads = loadLeads();
    $filtered = array_values(array_filter(
        $leads,
        static fn (array $lead): bool => ($lead['id'] ?? '') !== $id
    ));

    if (count($filtered) === count($leads)) {
        return false;
    }

    return saveLeads($filtered);
}

function auditIndustries(): array
{
    return [
        'E-commerce',
        'Healthcare',
        'Real Estate',
        'Education',
        'Finance / Fintech',
        'Food & Restaurant',
        'Travel & Hospitality',
        'Technology / SaaS',
        'Fashion & Beauty',
        'Automotive',
        'Legal Services',
        'Fitness & Wellness',
        'Local Business',
        'Other',
    ];
}

/**
 * Popular dial codes — value is the digits-only dial code (e.g. "91").
 *
 * @return array<string, string>
 */
function countryDialCodes(): array
{
    return [
        '91' => 'India (+91)',
        '1' => 'United States / Canada (+1)',
        '44' => 'United Kingdom (+44)',
        '971' => 'United Arab Emirates (+971)',
        '966' => 'Saudi Arabia (+966)',
        '974' => 'Qatar (+974)',
        '965' => 'Kuwait (+965)',
        '973' => 'Bahrain (+973)',
        '968' => 'Oman (+968)',
        '92' => 'Pakistan (+92)',
        '880' => 'Bangladesh (+880)',
        '94' => 'Sri Lanka (+94)',
        '977' => 'Nepal (+977)',
        '61' => 'Australia (+61)',
        '64' => 'New Zealand (+64)',
        '65' => 'Singapore (+65)',
        '60' => 'Malaysia (+60)',
        '62' => 'Indonesia (+62)',
        '63' => 'Philippines (+63)',
        '66' => 'Thailand (+66)',
        '81' => 'Japan (+81)',
        '82' => 'South Korea (+82)',
        '86' => 'China (+86)',
        '852' => 'Hong Kong (+852)',
        '49' => 'Germany (+49)',
        '33' => 'France (+33)',
        '39' => 'Italy (+39)',
        '34' => 'Spain (+34)',
        '31' => 'Netherlands (+31)',
        '46' => 'Sweden (+46)',
        '47' => 'Norway (+47)',
        '41' => 'Switzerland (+41)',
        '353' => 'Ireland (+353)',
        '27' => 'South Africa (+27)',
        '234' => 'Nigeria (+234)',
        '254' => 'Kenya (+254)',
        '20' => 'Egypt (+20)',
        '55' => 'Brazil (+55)',
        '52' => 'Mexico (+52)',
        '54' => 'Argentina (+54)',
        '7' => 'Russia / Kazakhstan (+7)',
        '90' => 'Turkey (+90)',
        '972' => 'Israel (+972)',
    ];
}

function formatLeadPhone(array $lead): string
{
    $code = preg_replace('/\D+/', '', (string) ($lead['country_code'] ?? '')) ?? '';
    $phone = trim((string) ($lead['phone'] ?? ''));
    $digits = preg_replace('/\D+/', '', $phone) ?? '';

    if ($code !== '' && $digits !== '') {
        return '+' . $code . ' ' . $phone;
    }
    if ($phone !== '') {
        return $phone;
    }
    return '';
}

function leadTelHref(array $lead): string
{
    $code = preg_replace('/\D+/', '', (string) ($lead['country_code'] ?? '')) ?? '';
    $digits = preg_replace('/\D+/', '', (string) ($lead['phone'] ?? '')) ?? '';
    if ($code !== '' && $digits !== '') {
        return '+' . $code . $digits;
    }
    return $digits !== '' ? $digits : '';
}
