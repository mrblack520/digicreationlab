<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/content.php';
require_once __DIR__ . '/../includes/helpers.php';

adminRequireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$section = $_POST['section'] ?? '';
$content = loadSiteContent();

try {
    switch ($section) {
        case 'site':
            $content['site'] = [
                'brand_name' => trim($_POST['brand_name'] ?? ''),
                'logo_mark' => trim($_POST['logo_mark'] ?? ($content['site']['logo_mark'] ?? 'N')),
                'logo_image' => handleImageUpload('logo_image_file', trim($_POST['logo_image'] ?? '')),
                'favicon' => handleImageUpload('favicon_file', trim($_POST['favicon'] ?? '')),
                'page_title' => trim($_POST['page_title'] ?? 'Home'),
            ];
            break;

        case 'header':
            $existingLinks = $content['header']['nav_links'] ?? [];
            $content['header'] = [
                'nav_links' => $existingLinks,
                'nav_label' => trim($_POST['nav_label'] ?? ''),
                'nav_url' => trim($_POST['nav_url'] ?? '#'),
                'cta_text' => trim($_POST['cta_text'] ?? ''),
                'cta_url' => trim($_POST['cta_url'] ?? '#'),
            ];
            break;

        case 'hero':
            $content['hero'] = [
                'title' => trim($_POST['title'] ?? ''),
                'subtitle' => trim($_POST['subtitle'] ?? ''),
                'hero_image' => handleImageUpload('hero_image_file', trim($_POST['hero_image'] ?? '')),
                'cta_url' => trim($_POST['cta_url'] ?? '#contact'),
            ];
            break;

        case 'trust_bar':
            $content['trust_bar'] = [
                'experts_text' => trim($_POST['experts_text'] ?? ''),
                'experts_url' => trim($_POST['experts_url'] ?? '#'),
                'avatar_1' => handleImageUpload('avatar_1_file', trim($_POST['avatar_1'] ?? '')),
                'avatar_2' => handleImageUpload('avatar_2_file', trim($_POST['avatar_2'] ?? '')),
                'avatar_3' => handleImageUpload('avatar_3_file', trim($_POST['avatar_3'] ?? '')),
                'revenue_number' => preg_replace('/\D+/', '', $_POST['revenue_number'] ?? '0'),
                'revenue_label' => trim($_POST['revenue_label'] ?? ''),
                'reviews_count' => preg_replace('/\D+/', '', $_POST['reviews_count'] ?? '0'),
                'reviews_suffix' => trim($_POST['reviews_suffix'] ?? ''),
            ];
            break;

        case 'what_we_do':
            $content['what_we_do'] = [
                'eyebrow' => trim($_POST['eyebrow'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'intro' => trim($_POST['intro'] ?? ''),
                'link_text' => trim($_POST['link_text'] ?? ''),
                'link_url' => trim($_POST['link_url'] ?? '#'),
                'cards' => parseRepeaterJson($_POST['cards_json'] ?? ''),
            ];
            break;

        case 'capabilities':
            $content['capabilities'] = [
                'banner_image' => handleImageUpload('banner_image_file', trim($_POST['banner_image'] ?? '')),
                'banner_alt' => trim($_POST['banner_alt'] ?? ''),
                'eyebrow' => trim($_POST['eyebrow'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'button_text' => trim($_POST['button_text'] ?? ''),
                'button_url' => trim($_POST['button_url'] ?? '#'),
                'cards' => parseRepeaterJson($_POST['cards_json'] ?? ''),
            ];
            break;

        case 'why_section':
            $tabsRaw = $_POST['tabs_json_visible'] ?? $_POST['tabs_json'] ?? '';
            $content['why_section'] = [
                'side_title' => trim($_POST['side_title'] ?? ''),
                'side_text' => trim($_POST['side_text'] ?? ''),
                'button_text' => trim($_POST['button_text'] ?? ''),
                'button_url' => trim($_POST['button_url'] ?? '#'),
                'tabs' => parseRepeaterJson($tabsRaw),
            ];
            break;

        case 'stories':
            $content['stories'] = [
                'eyebrow' => trim($_POST['eyebrow'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'link_text' => trim($_POST['link_text'] ?? ''),
                'link_url' => trim($_POST['link_url'] ?? '#'),
                'items' => parseRepeaterJson($_POST['items_json'] ?? ''),
            ];
            break;

        case 'logos':
            $content['logos'] = [
                'title' => trim($_POST['title'] ?? ''),
                'items' => parseRepeaterJson($_POST['items_json'] ?? ''),
            ];
            break;

        case 'blog':
            $content['blog'] = [
                'eyebrow' => trim($_POST['eyebrow'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'posts' => parseRepeaterJson($_POST['posts_json'] ?? ''),
            ];
            break;

        case 'stats_section':
            $content['stats_section'] = [
                'title' => trim($_POST['title'] ?? ''),
                'circles' => parseRepeaterJson($_POST['circles_json'] ?? ''),
                'leads_number' => preg_replace('/\D+/', '', $_POST['leads_number'] ?? '0'),
                'leads_suffix' => trim($_POST['leads_suffix'] ?? '+'),
                'leads_text' => trim($_POST['leads_text'] ?? ''),
                'leads_button' => trim($_POST['leads_button'] ?? ''),
                'leads_url' => trim($_POST['leads_url'] ?? '#'),
            ];
            break;

        case 'testimonials':
            $content['testimonials'] = [
                'reviews_text' => trim($_POST['reviews_text'] ?? ''),
                'reviews_link_text' => trim($_POST['reviews_link_text'] ?? ''),
                'reviews_link_url' => trim($_POST['reviews_link_url'] ?? '#'),
                'items' => parseRepeaterJson($_POST['items_json'] ?? ''),
            ];
            break;

        case 'pricing':
            $categories = parseRepeaterJson($_POST['categories_json'] ?? '', []);
            $normalized = [];
            foreach ($categories as $cat) {
                if (!is_array($cat)) {
                    continue;
                }
                $title = trim((string) ($cat['title'] ?? ''));
                $id = trim((string) ($cat['id'] ?? ''));
                if ($id === '' && $title !== '') {
                    $id = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title) ?? '');
                    $id = trim($id, '-');
                }
                if ($id === '' && $title === '') {
                    continue;
                }

                $plans = [];
                foreach (($cat['plans'] ?? []) as $plan) {
                    if (!is_array($plan)) {
                        continue;
                    }
                    $name = trim((string) ($plan['name'] ?? ''));
                    $featuresRaw = $plan['features'] ?? [];
                    if (is_string($featuresRaw)) {
                        $features = linesToArray(str_replace(',', "\n", $featuresRaw));
                    } elseif (is_array($featuresRaw)) {
                        $features = array_values(array_filter(array_map(
                            static fn ($f) => trim((string) $f),
                            $featuresRaw
                        ), static fn ($f) => $f !== ''));
                    } else {
                        $features = [];
                    }

                    if ($name === '' && $features === [] && trim((string) ($plan['price'] ?? '')) === '') {
                        continue;
                    }

                    $plans[] = [
                        'name' => $name !== '' ? $name : 'Plan',
                        'description' => trim((string) ($plan['description'] ?? '')),
                        'price' => trim((string) ($plan['price'] ?? '')),
                        'old_price' => trim((string) ($plan['old_price'] ?? '')),
                        'period' => trim((string) ($plan['period'] ?? '')),
                        'badge' => trim((string) ($plan['badge'] ?? '')),
                        'featured' => !empty($plan['featured']) && $plan['featured'] !== '0' && $plan['featured'] !== false,
                        'features' => $features,
                        'button_text' => trim((string) ($plan['button_text'] ?? 'Order Now')) ?: 'Order Now',
                        'button_url' => trim((string) ($plan['button_url'] ?? 'index.php#contact')) ?: 'index.php#contact',
                    ];
                }

                $normalized[] = [
                    'id' => $id !== '' ? $id : 'category-' . (count($normalized) + 1),
                    'title' => $title !== '' ? $title : 'Category',
                    'subtitle' => trim((string) ($cat['subtitle'] ?? '')),
                    'plans' => $plans,
                ];
            }

            $content['pricing'] = [
                'page_title' => trim($_POST['page_title'] ?? 'Pricing'),
                'eyebrow' => trim($_POST['eyebrow'] ?? 'Pricing'),
                'title' => trim($_POST['title'] ?? ''),
                'subtitle' => trim($_POST['subtitle'] ?? ''),
                'currency' => trim($_POST['currency'] ?? '$') ?: '$',
                'categories' => $normalized,
            ];
            break;

        case 'portfolio':
            $content['portfolio'] = [
                'page_title' => trim($_POST['page_title'] ?? 'Portfolio'),
                'hero_title' => trim($_POST['hero_title'] ?? ''),
                'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),
                'hero_image' => handleImageUpload('hero_image_file', trim($_POST['hero_image'] ?? '')),
                'logos' => buildPortfolioItems('logo', false),
                'websites' => buildPortfolioItems('website', true),
            ];
            break;

        case 'social':
            $content['social'] = [
                'whatsapp_number' => preg_replace('/\D+/', '', $_POST['whatsapp_number'] ?? ''),
                'whatsapp_message' => trim($_POST['whatsapp_message'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'instagram' => trim($_POST['instagram'] ?? '#'),
                'tiktok' => trim($_POST['tiktok'] ?? '#'),
                'twitter' => trim($_POST['twitter'] ?? '#'),
                'facebook' => trim($_POST['facebook'] ?? '#'),
                'youtube' => trim($_POST['youtube'] ?? '#'),
            ];
            // Keep footer social icons in sync
            $content['footer']['social_instagram'] = $content['social']['instagram'];
            $content['footer']['social_twitter'] = $content['social']['twitter'];
            $content['footer']['social_facebook'] = $content['social']['facebook'];
            $content['footer']['social_youtube'] = $content['social']['youtube'];
            if ($content['social']['phone'] !== '') {
                $content['footer_cta']['phone'] = $content['social']['phone'];
            }
            break;

        case 'footer_cta':
            $content['footer_cta'] = [
                'title' => trim($_POST['title'] ?? ''),
                'partner_eyebrow' => trim($_POST['partner_eyebrow'] ?? ''),
                'partners' => trim($_POST['partners'] ?? ''),
                'phone_label' => trim($_POST['phone_label'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'button_text' => trim($_POST['button_text'] ?? ''),
                'button_url' => trim($_POST['button_url'] ?? '#'),
                'roas_title' => trim($_POST['roas_title'] ?? ''),
                'roas_text' => trim($_POST['roas_text'] ?? ''),
            ];
            break;

        case 'footer':
            $content['footer'] = [
                'solutions_eyebrow' => trim($_POST['solutions_eyebrow'] ?? ''),
                'links_col1' => trim($_POST['links_col1'] ?? ''),
                'links_col2' => trim($_POST['links_col2'] ?? ''),
                'links_col3' => trim($_POST['links_col3'] ?? ''),
                'links_col4' => trim($_POST['links_col4'] ?? ''),
                'nav' => trim($_POST['nav'] ?? ''),
                'copyright' => trim($_POST['copyright'] ?? ''),
                'terms_url' => trim($_POST['terms_url'] ?? '#'),
                'privacy_url' => trim($_POST['privacy_url'] ?? '#'),
                'social_instagram' => trim($_POST['social_instagram'] ?? '#'),
                'social_twitter' => trim($_POST['social_twitter'] ?? '#'),
                'social_facebook' => trim($_POST['social_facebook'] ?? '#'),
                'social_youtube' => trim($_POST['social_youtube'] ?? '#'),
            ];
            $content['social'] = array_replace_recursive($content['social'] ?? [], [
                'instagram' => $content['footer']['social_instagram'],
                'twitter' => $content['footer']['social_twitter'],
                'facebook' => $content['footer']['social_facebook'],
                'youtube' => $content['footer']['social_youtube'],
            ]);
            break;

        case 'password':
            $current = $_POST['current_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $config = adminConfig();

            if (!password_verify($current, $config['password_hash'])) {
                throw new RuntimeException('Current password is incorrect.');
            }
            if (strlen($newPass) < 6) {
                throw new RuntimeException('New password must be at least 6 characters.');
            }
            if ($newPass !== $confirm) {
                throw new RuntimeException('New passwords do not match.');
            }

            $configPath = __DIR__ . '/../config/admin.php';
            $newHash = password_hash($newPass, PASSWORD_DEFAULT);
            $file = "<?php\nreturn [\n    'username' => " . var_export($config['username'], true) . ",\n    'password_hash' => " . var_export($newHash, true) . ",\n];\n";
            file_put_contents($configPath, $file, LOCK_EX);
            adminFlash('success', 'Password updated successfully.');
            header('Location: index.php#settings');
            exit;

        default:
            throw new RuntimeException('Unknown section.');
    }

    if (!saveSiteContent($content)) {
        throw new RuntimeException('Failed to save content.');
    }

    adminFlash('success', 'Changes saved successfully.');
} catch (Throwable $e) {
    adminFlash('error', $e->getMessage());
}

$redirect = 'index.php';
if ($section && $section !== 'password') {
    $redirect .= '#' . $section;
}
header('Location: ' . $redirect);
exit;
