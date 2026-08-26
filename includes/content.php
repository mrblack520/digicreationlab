<?php

declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function contentFilePath(): string
{
    return __DIR__ . '/../data/site-content.json';
}

function defaultSiteContent(): array
{
    return [
        'site' => [
            'brand_name' => 'NUMÉRIQUE',
            'logo_mark' => 'N',
            'logo_image' => '',
            'favicon' => '',
            'page_title' => 'Home',
        ],
        'header' => [
            'nav_links' => [
                ['label' => 'Call Now', 'url' => 'tel:8884005050'],
                ['label' => 'Pricing', 'url' => 'pricing.php'],
                ['label' => 'Portfolio', 'url' => 'portfolio.php'],
            ],
            'nav_label' => 'Contact',
            'nav_url' => '#contact',
            'cta_text' => 'Free Audit',
            'cta_url' => '#audit',
        ],
        'hero' => [
            'title' => 'Marketing without borders',
            'subtitle' => 'Amplify your business with our data-centric, performance-driven digital marketing solutions.',
            'hero_image' => 'assets/img/hero-image.png',
            'cta_url' => '#contact',
        ],
        'trust_bar' => [
            'experts_text' => 'Connect our experts →',
            'experts_url' => '#contact',
            'avatar_1' => 'assets/img/avatar-1.svg',
            'avatar_2' => 'assets/img/avatar-2.svg',
            'avatar_3' => 'assets/img/avatar-3.svg',
            'revenue_number' => '2120240368',
            'revenue_label' => "Revenue driven\nfor our clients",
            'reviews_count' => '5000',
            'reviews_suffix' => '+ Client reviews',
        ],
        'what_we_do' => [
            'eyebrow' => 'What we do',
            'title' => "We solve digital\nchallenges",
            'intro' => 'We help businesses grow by delivering tangible, measurable results. Our team of experts is dedicated to helping you achieve your goals and drive success in the digital world.',
            'link_text' => 'More about us',
            'link_url' => '#capabilities',
            'cards' => [
                ['title' => 'Better audiences', 'icon' => '📣', 'text' => 'We help businesses grow by delivering tangible, measurable results. Our team of experts is dedicated to helping you achieve your goals.'],
                ['title' => 'Better analytics', 'icon' => '📊', 'text' => 'We help businesses grow by delivering tangible, measurable results. Our team of experts is dedicated to helping you achieve your goals.'],
                ['title' => 'Better outcomes', 'icon' => '💰', 'text' => 'We help businesses grow by delivering tangible, measurable results. Our team of experts is dedicated to helping you achieve your goals.'],
            ],
        ],
        'capabilities' => [
            'banner_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1400&q=80',
            'banner_alt' => 'Team collaborating in a modern office',
            'eyebrow' => 'Our capabilities',
            'title' => 'Data-driven, customer-centric digital services',
            'button_text' => 'View all solutions',
            'button_url' => '#capabilities',
            'cards' => [
                ['icon' => '🔍', 'title' => 'Paid search marketing', 'text' => 'Craft campaigns — built just for your business — to ensure real and quantifiable ROI.', 'link' => '#'],
                ['icon' => '🎯', 'title' => 'Search engine optimization', 'text' => 'Maintain your best spot on the search results page, so you can find new customers and re-engage loyal ones.', 'link' => '#'],
                ['icon' => '✉️', 'title' => 'Email marketing', 'text' => "When it comes to reaching your target audience, you can't get much closer than direct to their inboxes.", 'link' => '#'],
                ['icon' => '🚀', 'title' => 'Conversion rate optimization', 'text' => 'Craft campaigns — built just for your business — to ensure real and quantifiable ROI.', 'link' => '#'],
            ],
        ],
        'why_section' => [
            'side_title' => 'Why Numerique is your top-choice',
            'side_text' => "We're a five-star rated, holistic full-service digital marketing agency. We believe in forming long-term partnerships with our clients, and we do that by delivering exceptional results and outstanding customer service.",
            'button_text' => 'Get proposal',
            'button_url' => '#contact',
            'tabs' => [
                [
                    'id' => 'transparency',
                    'label' => 'Transparency',
                    'title' => '100% Campaign transparency',
                    'text' => "We believe in complete transparency with our clients. You'll have full visibility into your campaigns, performance metrics, and strategies at all times.",
                    'type' => 'chart',
                ],
                [
                    'id' => 'experts',
                    'label' => 'Team of experts',
                    'title' => 'Team of experts',
                    'text' => 'Our certified specialists across SEO, PPC, social, and analytics work as an extension of your team — strategists, creatives, and analysts under one roof.',
                    'type' => 'stats',
                    'stats' => [
                        ['value' => '50+', 'label' => 'Certified experts'],
                        ['value' => '12', 'label' => 'Years avg. experience'],
                        ['value' => '24/7', 'label' => 'Client support'],
                    ],
                ],
                [
                    'id' => 'results',
                    'label' => 'Results',
                    'title' => 'Results that matter',
                    'text' => 'We focus on metrics that drive revenue — ROAS, CAC, LTV, and conversion rates — not vanity numbers. Every campaign is built for measurable growth.',
                    'type' => 'stats',
                    'stats' => [
                        ['value' => '6.7×', 'label' => 'Average ROAS'],
                        ['value' => '37%', 'label' => 'Avg. sales lift'],
                        ['value' => '100+', 'label' => 'Global clients'],
                    ],
                ],
            ],
        ],
        'stories' => [
            'eyebrow' => 'Success stories',
            'title' => "Our work drives\nbusinesses forward",
            'link_text' => 'View all',
            'link_url' => '#work',
            'items' => [
                [
                    'brand' => 'ZARA',
                    'result' => '+40% Ecommerce growth',
                    'image' => 'https://images.unsplash.com/photo-1483985988354-763728e1935b?auto=format&fit=crop&w=800&q=80',
                    'tags' => 'Paid Search, Paid Social, SEO',
                ],
                [
                    'brand' => 'Homme',
                    'result' => '+50% Engagement rates',
                    'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                    'tags' => 'Organic Social Media, Paid Social',
                ],
            ],
        ],
        'logos' => [
            'title' => 'The best brands choose Numerique',
            'items' => [
                ['text' => 'JOLIE.', 'class' => ''],
                ['text' => 'caridad.', 'class' => 'script'],
                ['text' => 'F7', 'class' => 'bold'],
                ['text' => 'scuola', 'class' => ''],
                ['text' => '🐾 PetMania', 'class' => ''],
                ['text' => '⬡ Tecnologia', 'class' => ''],
            ],
        ],
        'blog' => [
            'eyebrow' => 'Blog',
            'title' => 'Think further with our expert insights',
            'posts' => [
                [
                    'date' => 'May 2023',
                    'datetime' => '2023-05',
                    'title' => 'The evolution of live-stream content and what it means for marketers',
                    'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=600&q=80',
                ],
                [
                    'date' => 'May 2023',
                    'datetime' => '2023-05',
                    'title' => 'The Metaverse boom: how brands can leverage virtual worlds',
                    'image' => 'https://images.unsplash.com/photo-1622979135225-d2fe269b5b64?auto=format&fit=crop&w=600&q=80',
                ],
                [
                    'date' => 'May 2023',
                    'datetime' => '2023-05',
                    'title' => 'Verify your site is protecting your business and customers',
                    'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80',
                ],
            ],
        ],
        'stats_section' => [
            'title' => 'The proof is in the numbers',
            'circles' => [
                ['value' => '37', 'suffix' => '%', 'label' => 'Average increase in sales for our clients'],
                ['value' => '100', 'suffix' => '%', 'label' => 'Client satisfaction rate across all services'],
                ['value' => '81', 'suffix' => '%', 'label' => 'Of clients see ROI within the first 6 months'],
            ],
            'leads_number' => '282000',
            'leads_suffix' => '+',
            'leads_text' => 'Leads generated so far...',
            'leads_button' => 'Contact us',
            'leads_url' => '#contact',
        ],
        'testimonials' => [
            'reviews_text' => '5000+ Client reviews',
            'reviews_link_text' => 'View all reviews →',
            'reviews_link_url' => '#',
            'items' => [
                ['quote' => 'The entire staff at Numerique has been phenomenal. They are quick with their replies and incredibly helpful.', 'name' => 'Edward Kennedy', 'role' => 'Director, Client Experience'],
                ['quote' => 'Numerique transformed our digital presence. Our leads increased by 200% in just 3 months.', 'name' => 'Sarah Mitchell', 'role' => 'CMO, TechFlow Inc.'],
                ['quote' => "Professional, transparent, and results-driven. The best agency we've ever worked with.", 'name' => 'James Rodriguez', 'role' => 'Founder, GrowthLab'],
            ],
        ],
        'pricing' => [
            'page_title' => 'Pricing',
            'eyebrow' => 'Pricing',
            'title' => 'Packages for every stage',
            'subtitle' => 'Browse logo, website, animation, and bundle packages. Pick what fits your brand.',
            'currency' => '$',
            'categories' => [
                [
                    'id' => '3in1',
                    'title' => '3 IN 1 BUNDLES',
                    'subtitle' => 'LOGO + WEBSITE + BRANDING KIT',
                    'plans' => [
                        [
                            'name' => 'Basic',
                            'description' => 'Bundle',
                            'price' => '499',
                            'old_price' => '557',
                            'period' => '',
                            'badge' => '',
                            'featured' => false,
                            'features' => [
                                'Single Page Website — $399',
                                'Silver Logo — $99',
                                'Basic Branding Kit — $59',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Pro',
                            'description' => 'Bundle',
                            'price' => '999',
                            'old_price' => '1087',
                            'period' => '',
                            'badge' => 'Popular',
                            'featured' => true,
                            'features' => [
                                'Basic Static Website — $699',
                                'Platinum Logo — $189',
                                'Corporate Kit — $199',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Corporate',
                            'description' => 'Bundle',
                            'price' => '1499',
                            'old_price' => '1587',
                            'period' => '',
                            'badge' => '',
                            'featured' => false,
                            'features' => [
                                'CMS Website — $1199',
                                'Platinum Logo — $189',
                                'Corporate Kit — $199',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Ultimate',
                            'description' => 'Bundle',
                            'price' => '1,999',
                            'old_price' => '2387',
                            'period' => '',
                            'badge' => '',
                            'featured' => false,
                            'features' => [
                                'E-COM Website — $1699',
                                'Platinum Logo — $189',
                                'Ultimate Kit — $499',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                    ],
                ],
                [
                    'id' => '2in1',
                    'title' => '2 IN 1 BUNDLES',
                    'subtitle' => 'LOGO + BRANDING KIT',
                    'plans' => [
                        [
                            'name' => 'Basic',
                            'description' => 'Bundle',
                            'price' => '89',
                            'old_price' => '108',
                            'period' => '',
                            'features' => ['Bronze Logo — $49', 'Basic Branding Kit — $59'],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Pro',
                            'description' => 'Bundle',
                            'price' => '219',
                            'old_price' => '248',
                            'period' => '',
                            'badge' => 'Popular',
                            'featured' => true,
                            'features' => ['Silver Logo — $99', 'Pro Branding Kit — $149'],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Corporate',
                            'description' => 'Bundle',
                            'price' => '299',
                            'old_price' => '338',
                            'period' => '',
                            'features' => ['Gold Logo — $139', 'Corporate Branding Kit — $199'],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Ultimate',
                            'description' => 'Bundle',
                            'price' => '599',
                            'old_price' => '668',
                            'period' => '',
                            'features' => ['Platinum Logo — $189', 'Ultimate Branding Kit — $499'],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                    ],
                ],
                [
                    'id' => 'logo',
                    'title' => 'LOGO PACKAGES',
                    'subtitle' => 'Professional logo design packages',
                    'plans' => [
                        [
                            'name' => 'Bronze',
                            'description' => 'Logo',
                            'price' => '49',
                            'period' => '',
                            'features' => [
                                '2 Logo Concepts',
                                '3 Revisions',
                                'No High Res. files',
                                '48 hours Delivery',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Silver',
                            'description' => 'Logo',
                            'price' => '99',
                            'period' => '',
                            'badge' => 'Popular',
                            'featured' => true,
                            'features' => [
                                '4 Logo Concepts',
                                '6 Revisions',
                                'Custom Logo',
                                'Vector PDF File',
                                '48 hours Delivery',
                                'HQ PNG + JPEG',
                                '100% Ownership',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Gold',
                            'description' => 'Logo',
                            'price' => '139',
                            'period' => '',
                            'features' => [
                                '6 Logo Concepts',
                                'Unlimited Revisions',
                                'Custom Logo',
                                'Vector EPS, PDF file',
                                '24-48 H Delivery',
                                'HQ PNG + JPEG',
                                '100% Ownership',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Platinum',
                            'description' => 'Logo',
                            'price' => '189',
                            'period' => '',
                            'features' => [
                                'Unlimited Concepts',
                                'Unlimited Revisions',
                                'Custom Logo',
                                'Editable Vector AI',
                                '24-48 H Delivery',
                                'Vector EPS, PDF',
                                'HQ PNG + JPEG',
                                '100% Ownership',
                                'Business Card Design',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                    ],
                ],
                [
                    'id' => 'animated-logo',
                    'title' => 'ANIMATED LOGO',
                    'subtitle' => 'Motion logo animation packages',
                    'plans' => [
                        [
                            'name' => 'Bronze',
                            'description' => 'Animated Logo',
                            'price' => '299',
                            'period' => '',
                            'features' => [
                                'Up to 4 Seconds',
                                'HD Quality 1920x1080',
                                '72 Hrs Delivery Time',
                                'Dedicated Specialist Logo Animator',
                                'Template Base Logo Animation',
                                'Royalty-free BG & SFX',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Silver',
                            'description' => 'Animated Logo',
                            'price' => '399',
                            'period' => '',
                            'badge' => 'Popular',
                            'featured' => true,
                            'features' => [
                                'Up to 8 Seconds',
                                'HD Quality 1920x1080',
                                '72 Hrs Delivery Time',
                                'Dedicated Specialist Logo Animator',
                                'Custom Animation',
                                'Text Base Logo Animation',
                                'Royalty-free BG & SFX',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Gold',
                            'description' => 'Animated Logo',
                            'price' => '499',
                            'period' => '',
                            'features' => [
                                'Up to 10 Seconds',
                                'HD Quality 1920x1080',
                                '72 Hrs Delivery Time',
                                'Dedicated Specialist Logo Animator',
                                'Tagline Voice Over',
                                'Custom motion graphic logo animation',
                                'Royalty-free BG & SFX',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Platinum',
                            'description' => 'Animated Logo',
                            'price' => '899',
                            'period' => '',
                            'features' => [
                                'Up to 20 Seconds',
                                'HD Quality 1920x1080',
                                '72 Hrs Delivery Time',
                                'Dedicated Specialist Logo Animator',
                                'Custom Logo animation with 3D effects',
                                'Royalty-free BG & SFX',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                    ],
                ],
                [
                    'id' => 'website',
                    'title' => 'WEBSITE PACKAGES',
                    'subtitle' => 'Static, dynamic, e-commerce & portal websites',
                    'plans' => [
                        [
                            'name' => 'Static',
                            'description' => 'Website',
                            'price' => '699',
                            'period' => '',
                            'features' => [
                                '5 Page Static Website',
                                'Jquery Slider Banner',
                                'W3C Certified HTML',
                                'UI Design',
                                '3 Banner Design',
                                'Favicon',
                                'SEO Friendly Design',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Dynamic',
                            'description' => 'Website',
                            'price' => '1,199',
                            'period' => '',
                            'badge' => 'Popular',
                            'featured' => true,
                            'features' => [
                                'Web Development',
                                '5 Pages Dynamic Website',
                                'Jquery Slider Banner',
                                'W3C Certified HTML',
                                'Web Design & UI',
                                '10 Stock Images',
                                '5 Banner Designs',
                                'Advance UI Effects',
                                'SEO Friendly Design',
                                'SEO Friendly Sitemap',
                                'Social Media Integration',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'E-Com',
                            'description' => 'Website',
                            'price' => '1,699',
                            'period' => '',
                            'features' => [
                                'Web Development',
                                'Unlimited Pages',
                                'Admin Panel Support',
                                'Mobile Responsive Layout',
                                'Cart Integration',
                                'Payment Module Integration',
                                'Inventory Management',
                                '50 Products & up to 10 Categories',
                                'Product Search & Reviews',
                                '8 Banner Designs',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                        [
                            'name' => 'Portal',
                            'description' => 'Website',
                            'price' => 'Starting from 2,999',
                            'period' => '',
                            'features' => [
                                'Web Development',
                                'Job / Social / Media / Real Estate Portal options',
                                'Client/User Dashboard',
                                'Custom Coding',
                                'Module-wise Architecture',
                                'Extensive Admin Panel',
                                'Complete Deployment',
                            ],
                            'button_text' => 'Order Now',
                            'button_url' => 'index.php#contact',
                        ],
                    ],
                ],
            ],
        ],
        'portfolio' => [
            'page_title' => 'Portfolio',
            'hero_title' => 'Our creative portfolio',
            'hero_subtitle' => 'Explore brand logos and website projects we have designed and delivered for our clients.',
            'hero_image' => '',
            'logos' => [
                ['title' => 'Brand Logo 1', 'image' => 'assets/img/trophy-card.png'],
                ['title' => 'Brand Logo 2', 'image' => 'assets/img/megaphone-card.png'],
            ],
            'websites' => [
                ['title' => 'Website Project 1', 'image' => 'assets/img/hero-bento.png', 'url' => '#'],
                ['title' => 'Website Project 2', 'image' => 'assets/img/abstract-scene.png', 'url' => '#'],
            ],
        ],
        'footer_cta' => [
            'title' => 'See how we can help your business grow with digital marketing',
            'partner_eyebrow' => 'A partner, not a vendor',
            'partners' => 'Google Cloud Partner, Meta Business Partners, Google Partner, Shopify Partner, TikTok Marketing Partners',
            'phone_label' => 'Ready to speak with a marketing expert? Give us a ring',
            'phone' => '888-400-5050',
            'button_text' => 'Get a free audit',
            'button_url' => '#audit',
            'roas_title' => '6.7 / Average ROAS',
            'roas_text' => 'across our 100+ Global Clients on SEO, PPC & Social',
        ],
        'social' => [
            'whatsapp_number' => '8884005050',
            'whatsapp_message' => 'Hi, I would like to know more about your services.',
            'instagram' => '#',
            'tiktok' => '#',
            'twitter' => '#',
            'facebook' => '#',
            'youtube' => '#',
        ],
        'footer' => [
            'solutions_eyebrow' => 'Solutions',
            'links_col1' => "Paid search marketing\nSearch engine optimization",
            'links_col2' => "Email marketing\nConversion rate optimization",
            'links_col3' => "Social Media Marketing\nGoogle shopping",
            'links_col4' => "Influencer marketing\nAmazon shopping",
            'nav' => 'About, Blog, Careers, Team, Success Stories, Awards, Contact',
            'copyright' => 'VamTam',
            'terms_url' => '#',
            'privacy_url' => '#',
            'social_instagram' => '#',
            'social_twitter' => '#',
            'social_facebook' => '#',
            'social_youtube' => '#',
        ],
    ];
}

function loadSiteContent(): array
{
    $path = contentFilePath();
    $defaults = defaultSiteContent();

    if (!is_file($path)) {
        saveSiteContent($defaults);
        return $defaults;
    }

    $raw = file_get_contents($path);
    if ($raw === false) {
        return $defaults;
    }

    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return $defaults;
    }

    return array_replace_recursive($defaults, $data);
}

function saveSiteContent(array $content): bool
{
    $path = contentFilePath();
    $dir = dirname($path);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    return file_put_contents($path, $json, LOCK_EX) !== false;
}

function updateSiteSection(string $section, array $data): bool
{
    $content = loadSiteContent();
    $content[$section] = array_replace_recursive($content[$section] ?? [], $data);
    return saveSiteContent($content);
}

function mergeSiteContent(array $patch): bool
{
    $content = loadSiteContent();
    $merged = array_replace_recursive($content, $patch);
    return saveSiteContent($merged);
}
