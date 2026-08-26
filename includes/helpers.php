<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function titleHtml(?string $value): string
{
    return nl2br(e($value));
}

function linesToArray(string $text): array
{
    $lines = preg_split('/\r\n|\r|\n|,/', $text) ?: [];
    return array_values(array_filter(array_map('trim', $lines), static fn ($l) => $l !== ''));
}

function parseLinkLines(string $text): array
{
    $items = [];
    foreach (linesToArray($text) as $line) {
        if (str_contains($line, '|')) {
            [$label, $url] = array_map('trim', explode('|', $line, 2));
            $items[] = ['label' => $label, 'url' => $url ?: '#'];
        } else {
            $items[] = ['label' => $line, 'url' => '#' . strtolower(str_replace(' ', '-', $line))];
        }
    }
    return $items;
}

function parseTags(string $text): array
{
    return linesToArray(str_replace(',', "\n", $text));
}

function parseRepeaterJson(?string $json, array $fallback = []): array
{
    if ($json === null || $json === '') {
        return $fallback;
    }
    $data = json_decode($json, true);
    return is_array($data) ? $data : $fallback;
}

function handleImageUpload(string $fieldName, string $current = ''): string
{
    if (empty($_FILES[$fieldName]['name']) || ($_FILES[$fieldName]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $current;
    }

    $file = $_FILES[$fieldName];
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return $current;
    }

    $allowed = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml', 'image/x-icon', 'image/vnd.microsoft.icon'];
    $mime = mime_content_type($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION) ?: '');
    $extOk = in_array($ext, ['jpg', 'jpeg', 'jfif', 'png', 'webp', 'gif', 'svg', 'ico'], true);
    if (!in_array($mime, $allowed, true) && !$extOk) {
        return $current;
    }

    $uploadDir = __DIR__ . '/../assets/img/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'jpg');
    if ($ext === 'jfif') {
        $ext = 'jpg';
    }
    if ($ext === '') {
        $ext = 'png';
    }
    $filename = 'upload_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return $current;
    }

    return 'assets/img/uploads/' . $filename;
}

/**
 * Build portfolio items from parallel POST arrays + optional file uploads.
 *
 * @param string $prefix e.g. logo or website
 * @param bool $withUrl
 * @return array<int, array<string, string>>
 */
function buildPortfolioItems(string $prefix, bool $withUrl = false): array
{
    $titles = $_POST[$prefix . '_title'] ?? [];
    $images = $_POST[$prefix . '_image'] ?? [];
    $urls = $_POST[$prefix . '_url'] ?? [];
    $files = $_FILES[$prefix . '_image_file'] ?? null;
    $items = [];

    if (!is_array($titles)) {
        return $items;
    }

    foreach ($titles as $i => $title) {
        $title = trim((string) $title);
        $image = trim((string) ($images[$i] ?? ''));

        if ($files && isset($files['name'][$i]) && $files['name'][$i] !== '') {
            $fakeField = $prefix . '_upload_' . $i;
            $_FILES[$fakeField] = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i] ?? '',
                'tmp_name' => $files['tmp_name'][$i] ?? '',
                'error' => $files['error'][$i] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$i] ?? 0,
            ];
            $image = handleImageUpload($fakeField, $image);
            unset($_FILES[$fakeField]);
        }

        if ($title === '' && $image === '') {
            continue;
        }

        $item = [
            'title' => $title !== '' ? $title : 'Untitled',
            'image' => $image,
        ];
        if ($withUrl) {
            $item['url'] = trim((string) ($urls[$i] ?? '#')) ?: '#';
        }
        $items[] = $item;
    }

    return $items;
}
