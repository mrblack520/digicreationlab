<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/content.php';
require_once __DIR__ . '/../includes/helpers.php';

adminRequireLogin();
$content = loadSiteContent();
$flash = adminGetFlash();

function jsonField(array $data): string
{
    return e(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Master Control</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">
  <aside class="admin-sidebar">
    <div class="sidebar-brand">Master Control</div>
    <nav class="sidebar-nav">
      <a href="leads.php">Leads</a>
      <a href="#site">Site & Logo</a>
      <a href="#header">Header</a>
      <a href="#hero">Hero</a>
      <a href="#trust_bar">Trust Bar</a>
      <a href="#what_we_do">What We Do</a>
      <a href="#capabilities">Capabilities</a>
      <a href="#why_section">Why / Tabs</a>
      <a href="#stories">Success Stories</a>
      <a href="#logos">Logo Strip</a>
      <a href="#blog">Blog</a>
      <a href="#stats_section">Statistics</a>
      <a href="#testimonials">Testimonials</a>
      <a href="#portfolio">Portfolio</a>
      <a href="#social">Social & WhatsApp</a>
      <a href="#footer_cta">Footer CTA</a>
      <a href="#footer">Footer</a>
      <a href="#settings">Settings</a>
    </nav>
    <div class="sidebar-actions">
      <a href="../index.php" target="_blank" class="sidebar-btn">View Site ↗</a>
      <a href="logout.php" class="sidebar-btn muted">Logout</a>
    </div>
  </aside>

  <main class="admin-main">
    <header class="admin-topbar">
      <h1>Landing Page Editor</h1>
      <p>Edit every section — changes go live on your Digi Creation site instantly.</p>
    </header>

    <?php if ($flash): ?>
    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
    <?php endif; ?>

    <!-- SITE -->
    <section class="admin-panel" id="site">
      <h2>Site & Logo</h2>
      <form action="save.php" method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="section" value="site">
        <div class="grid-2">
          <label>Brand Name<input type="text" name="brand_name" value="<?php echo e($content['site']['brand_name']); ?>"></label>
          <label>Page Title<input type="text" name="page_title" value="<?php echo e($content['site']['page_title']); ?>"></label>
        </div>

        <h3 class="admin-subhead">Logo</h3>
        <p class="hint">Header mein brand name ke saath ye logo image show hogi.</p>
        <input type="hidden" name="logo_mark" value="<?php echo e($content['site']['logo_mark'] ?? 'N'); ?>">
        <label>Logo Image URL<input type="text" name="logo_image" value="<?php echo e($content['site']['logo_image'] ?? ''); ?>"></label>
        <label>Upload Logo<input type="file" name="logo_image_file" accept="image/*"></label>
        <?php if (!empty($content['site']['logo_image'])): ?>
        <img src="../<?php echo e($content['site']['logo_image']); ?>" class="preview-img small" alt="Logo preview">
        <?php endif; ?>

        <h3 class="admin-subhead">Favicon</h3>
        <p class="hint">Browser tab icon. PNG / ICO / SVG recommended (square).</p>
        <label>Favicon URL<input type="text" name="favicon" value="<?php echo e($content['site']['favicon'] ?? ''); ?>"></label>
        <label>Upload Favicon<input type="file" name="favicon_file" accept="image/*,.ico"></label>
        <?php if (!empty($content['site']['favicon'])): ?>
        <img src="../<?php echo e($content['site']['favicon']); ?>" class="preview-img small" alt="Favicon preview">
        <?php endif; ?>

        <button type="submit" class="btn-save">Save Site Settings</button>
      </form>
    </section>

    <!-- HEADER -->
    <section class="admin-panel" id="header">
      <h2>Header Navigation</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="header">
        <div class="grid-2">
          <label>Nav Link Text<input type="text" name="nav_label" value="<?php echo e($content['header']['nav_label']); ?>"></label>
          <label>Nav Link URL<input type="text" name="nav_url" value="<?php echo e($content['header']['nav_url']); ?>"></label>
          <label>CTA Button Text<input type="text" name="cta_text" value="<?php echo e($content['header']['cta_text']); ?>"></label>
          <label>CTA Button URL<input type="text" name="cta_url" value="<?php echo e($content['header']['cta_url']); ?>"></label>
        </div>
        <button type="submit" class="btn-save">Save Header</button>
      </form>
    </section>

    <!-- HERO -->
    <section class="admin-panel" id="hero">
      <h2>Hero Section</h2>
      <form action="save.php" method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="section" value="hero">
        <label>Main Heading<input type="text" name="title" value="<?php echo e($content['hero']['title']); ?>"></label>
        <label>Subtitle<textarea name="subtitle" rows="2"><?php echo e($content['hero']['subtitle']); ?></textarea></label>
        <label>Hero Image URL<input type="text" name="hero_image" value="<?php echo e($content['hero']['hero_image']); ?>"></label>
        <label>Upload New Hero Image<input type="file" name="hero_image_file" accept="image/*"></label>
        <?php if ($content['hero']['hero_image']): ?><img src="../<?php echo e($content['hero']['hero_image']); ?>" class="preview-img" alt=""><?php endif; ?>
        <label>CTA Link URL<input type="text" name="cta_url" value="<?php echo e($content['hero']['cta_url']); ?>"></label>
        <button type="submit" class="btn-save">Save Hero</button>
      </form>
    </section>

    <!-- TRUST BAR -->
    <section class="admin-panel" id="trust_bar">
      <h2>Trust Bar / Stats</h2>
      <form action="save.php" method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="section" value="trust_bar">
        <div class="grid-2">
          <label>Experts Text<input type="text" name="experts_text" value="<?php echo e($content['trust_bar']['experts_text']); ?>"></label>
          <label>Experts URL<input type="text" name="experts_url" value="<?php echo e($content['trust_bar']['experts_url']); ?>"></label>
          <label>Revenue Number (no commas)<input type="text" name="revenue_number" value="<?php echo e($content['trust_bar']['revenue_number']); ?>"></label>
          <label>Reviews Count<input type="text" name="reviews_count" value="<?php echo e($content['trust_bar']['reviews_count']); ?>"></label>
        </div>
        <label>Revenue Label<textarea name="revenue_label" rows="2"><?php echo e($content['trust_bar']['revenue_label']); ?></textarea></label>
        <label>Reviews Suffix<input type="text" name="reviews_suffix" value="<?php echo e($content['trust_bar']['reviews_suffix']); ?>"></label>
        <div class="grid-3">
          <label>Avatar 1 URL<input type="text" name="avatar_1" value="<?php echo e($content['trust_bar']['avatar_1']); ?>"><input type="file" name="avatar_1_file" accept="image/*"></label>
          <label>Avatar 2 URL<input type="text" name="avatar_2" value="<?php echo e($content['trust_bar']['avatar_2']); ?>"><input type="file" name="avatar_2_file" accept="image/*"></label>
          <label>Avatar 3 URL<input type="text" name="avatar_3" value="<?php echo e($content['trust_bar']['avatar_3']); ?>"><input type="file" name="avatar_3_file" accept="image/*"></label>
        </div>
        <button type="submit" class="btn-save">Save Trust Bar</button>
      </form>
    </section>

    <!-- WHAT WE DO -->
    <section class="admin-panel" id="what_we_do">
      <h2>What We Do</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="cards" data-fields="title,icon,text">
        <input type="hidden" name="section" value="what_we_do">
        <input type="hidden" name="cards_json" value="<?php echo jsonField($content['what_we_do']['cards']); ?>">
        <div class="grid-2">
          <label>Eyebrow<input type="text" name="eyebrow" value="<?php echo e($content['what_we_do']['eyebrow']); ?>"></label>
          <label>Link Text<input type="text" name="link_text" value="<?php echo e($content['what_we_do']['link_text']); ?>"></label>
        </div>
        <label>Title (new line = line break)<textarea name="title" rows="2"><?php echo e($content['what_we_do']['title']); ?></textarea></label>
        <label>Intro<textarea name="intro" rows="3"><?php echo e($content['what_we_do']['intro']); ?></textarea></label>
        <label>Link URL<input type="text" name="link_url" value="<?php echo e($content['what_we_do']['link_url']); ?>"></label>
        <div class="repeater-wrap" data-json-field="cards_json"></div>
        <button type="button" class="btn-add">+ Add Card</button>
        <button type="submit" class="btn-save">Save What We Do</button>
      </form>
    </section>

    <!-- CAPABILITIES -->
    <section class="admin-panel" id="capabilities">
      <h2>Capabilities</h2>
      <form action="save.php" method="post" enctype="multipart/form-data" class="admin-form" data-repeater="cards" data-fields="icon,title,text,link">
        <input type="hidden" name="section" value="capabilities">
        <input type="hidden" name="cards_json" value="<?php echo jsonField($content['capabilities']['cards']); ?>">
        <label>Banner Image URL<input type="text" name="banner_image" value="<?php echo e($content['capabilities']['banner_image']); ?>"></label>
        <label>Upload Banner<input type="file" name="banner_image_file" accept="image/*"></label>
        <div class="grid-2">
          <label>Eyebrow<input type="text" name="eyebrow" value="<?php echo e($content['capabilities']['eyebrow']); ?>"></label>
          <label>Button Text<input type="text" name="button_text" value="<?php echo e($content['capabilities']['button_text']); ?>"></label>
        </div>
        <label>Title<input type="text" name="title" value="<?php echo e($content['capabilities']['title']); ?>"></label>
        <label>Banner Alt Text<input type="text" name="banner_alt" value="<?php echo e($content['capabilities']['banner_alt']); ?>"></label>
        <label>Button URL<input type="text" name="button_url" value="<?php echo e($content['capabilities']['button_url']); ?>"></label>
        <div class="repeater-wrap" data-json-field="cards_json"></div>
        <button type="button" class="btn-add">+ Add Service</button>
        <button type="submit" class="btn-save">Save Capabilities</button>
      </form>
    </section>

    <!-- WHY SECTION -->
    <section class="admin-panel" id="why_section">
      <h2>Why Numerique (Tabs)</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="why_section">
        <input type="hidden" name="tabs_json" id="tabs_json" value="<?php echo jsonField($content['why_section']['tabs']); ?>">
        <label>Side Title<input type="text" name="side_title" value="<?php echo e($content['why_section']['side_title']); ?>"></label>
        <label>Side Text<textarea name="side_text" rows="3"><?php echo e($content['why_section']['side_text']); ?></textarea></label>
        <div class="grid-2">
          <label>Button Text<input type="text" name="button_text" value="<?php echo e($content['why_section']['button_text']); ?>"></label>
          <label>Button URL<input type="text" name="button_url" value="<?php echo e($content['why_section']['button_url']); ?>"></label>
        </div>
        <p class="hint">Edit tabs as JSON (advanced). Each tab: id, label, title, text, type (chart|stats), stats array for stats type.</p>
        <label>Tabs JSON<textarea name="tabs_json_visible" rows="12" data-sync="tabs_json"><?php echo e(json_encode($content['why_section']['tabs'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></textarea></label>
        <button type="submit" class="btn-save">Save Why Section</button>
      </form>
    </section>

    <!-- STORIES -->
    <section class="admin-panel" id="stories">
      <h2>Success Stories</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="items" data-fields="brand,result,image,tags">
        <input type="hidden" name="section" value="stories">
        <input type="hidden" name="items_json" value="<?php echo jsonField($content['stories']['items']); ?>">
        <div class="grid-2">
          <label>Eyebrow<input type="text" name="eyebrow" value="<?php echo e($content['stories']['eyebrow']); ?>"></label>
          <label>Link Text<input type="text" name="link_text" value="<?php echo e($content['stories']['link_text']); ?>"></label>
        </div>
        <label>Title<textarea name="title" rows="2"><?php echo e($content['stories']['title']); ?></textarea></label>
        <label>Link URL<input type="text" name="link_url" value="<?php echo e($content['stories']['link_url']); ?>"></label>
        <div class="repeater-wrap" data-json-field="items_json"></div>
        <button type="button" class="btn-add">+ Add Story</button>
        <button type="submit" class="btn-save">Save Stories</button>
      </form>
    </section>

    <!-- LOGOS -->
    <section class="admin-panel" id="logos">
      <h2>Logo Strip</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="items" data-fields="text,class">
        <input type="hidden" name="section" value="logos">
        <input type="hidden" name="items_json" value="<?php echo jsonField($content['logos']['items']); ?>">
        <label>Section Title<input type="text" name="title" value="<?php echo e($content['logos']['title']); ?>"></label>
        <p class="hint">Class options: (empty), script, bold</p>
        <div class="repeater-wrap" data-json-field="items_json"></div>
        <button type="button" class="btn-add">+ Add Logo</button>
        <button type="submit" class="btn-save">Save Logos</button>
      </form>
    </section>

    <!-- BLOG -->
    <section class="admin-panel" id="blog">
      <h2>Blog</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="posts" data-fields="date,datetime,title,image">
        <input type="hidden" name="section" value="blog">
        <input type="hidden" name="posts_json" value="<?php echo jsonField($content['blog']['posts']); ?>">
        <div class="grid-2">
          <label>Eyebrow<input type="text" name="eyebrow" value="<?php echo e($content['blog']['eyebrow']); ?>"></label>
          <label>Section Title<input type="text" name="title" value="<?php echo e($content['blog']['title']); ?>"></label>
        </div>
        <div class="repeater-wrap" data-json-field="posts_json"></div>
        <button type="button" class="btn-add">+ Add Post</button>
        <button type="submit" class="btn-save">Save Blog</button>
      </form>
    </section>

    <!-- STATS -->
    <section class="admin-panel" id="stats_section">
      <h2>Statistics Section</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="circles" data-fields="value,suffix,label">
        <input type="hidden" name="section" value="stats_section">
        <input type="hidden" name="circles_json" value="<?php echo jsonField($content['stats_section']['circles']); ?>">
        <label>Section Title<input type="text" name="title" value="<?php echo e($content['stats_section']['title']); ?>"></label>
        <div class="repeater-wrap" data-json-field="circles_json"></div>
        <button type="button" class="btn-add">+ Add Circle</button>
        <hr>
        <div class="grid-2">
          <label>Leads Number<input type="text" name="leads_number" value="<?php echo e($content['stats_section']['leads_number']); ?>"></label>
          <label>Leads Suffix<input type="text" name="leads_suffix" value="<?php echo e($content['stats_section']['leads_suffix']); ?>"></label>
          <label>Leads Text<input type="text" name="leads_text" value="<?php echo e($content['stats_section']['leads_text']); ?>"></label>
          <label>Button Text<input type="text" name="leads_button" value="<?php echo e($content['stats_section']['leads_button']); ?>"></label>
        </div>
        <label>Button URL<input type="text" name="leads_url" value="<?php echo e($content['stats_section']['leads_url']); ?>"></label>
        <button type="submit" class="btn-save">Save Statistics</button>
      </form>
    </section>

    <!-- TESTIMONIALS -->
    <section class="admin-panel" id="testimonials">
      <h2>Testimonials</h2>
      <form action="save.php" method="post" class="admin-form" data-repeater="items" data-fields="quote,name,role">
        <input type="hidden" name="section" value="testimonials">
        <input type="hidden" name="items_json" value="<?php echo jsonField($content['testimonials']['items']); ?>">
        <div class="grid-2">
          <label>Reviews Text<input type="text" name="reviews_text" value="<?php echo e($content['testimonials']['reviews_text']); ?>"></label>
          <label>Reviews Link Text<input type="text" name="reviews_link_text" value="<?php echo e($content['testimonials']['reviews_link_text']); ?>"></label>
        </div>
        <label>Reviews Link URL<input type="text" name="reviews_link_url" value="<?php echo e($content['testimonials']['reviews_link_url']); ?>"></label>
        <div class="repeater-wrap" data-json-field="items_json"></div>
        <button type="button" class="btn-add">+ Add Testimonial</button>
        <button type="submit" class="btn-save">Save Testimonials</button>
      </form>
    </section>

    <!-- PORTFOLIO -->
    <section class="admin-panel" id="portfolio">
      <h2>Portfolio Page</h2>
      <form action="save.php" method="post" enctype="multipart/form-data" class="admin-form" id="portfolio-form">
        <input type="hidden" name="section" value="portfolio">
        <h3 class="admin-subhead">Hero</h3>
        <div class="grid-2">
          <label>Page Title<input type="text" name="page_title" value="<?php echo e($content['portfolio']['page_title'] ?? 'Portfolio'); ?>"></label>
          <label>Hero Title<input type="text" name="hero_title" value="<?php echo e($content['portfolio']['hero_title'] ?? ''); ?>"></label>
        </div>
        <label>Hero Subtitle<textarea name="hero_subtitle" rows="2"><?php echo e($content['portfolio']['hero_subtitle'] ?? ''); ?></textarea></label>
        <label>Hero Image URL<input type="text" name="hero_image" value="<?php echo e($content['portfolio']['hero_image'] ?? ''); ?>"></label>
        <label>Upload Hero Image<input type="file" name="hero_image_file" accept="image/*"></label>
        <?php if (!empty($content['portfolio']['hero_image'])): ?>
        <img src="../<?php echo e($content['portfolio']['hero_image']); ?>" class="preview-img" alt="">
        <?php endif; ?>

        <h3 class="admin-subhead">Logo Projects</h3>
        <p class="hint">Logo tab pe ye images show hongi. Empty row delete karne ke liye title + image blank chhor do.</p>
        <div class="portfolio-admin-list" id="logo-list">
          <?php foreach (($content['portfolio']['logos'] ?? []) as $i => $item): ?>
          <div class="portfolio-admin-row grid-2">
            <label>Title<input type="text" name="logo_title[]" value="<?php echo e($item['title'] ?? ''); ?>"></label>
            <label>Image URL<input type="text" name="logo_image[]" value="<?php echo e($item['image'] ?? ''); ?>"></label>
            <label>Upload Image<input type="file" name="logo_image_file[]" accept="image/*"></label>
            <?php if (!empty($item['image'])): ?>
            <img src="../<?php echo e($item['image']); ?>" class="preview-img small" alt="">
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" data-add-portfolio="logo">+ Add Logo</button>

        <h3 class="admin-subhead">Website Projects</h3>
        <p class="hint">Website tab pe ye projects show hongi. Optional project URL bhi add kar sakte ho.</p>
        <div class="portfolio-admin-list" id="website-list">
          <?php foreach (($content['portfolio']['websites'] ?? []) as $i => $item): ?>
          <div class="portfolio-admin-row grid-2">
            <label>Title<input type="text" name="website_title[]" value="<?php echo e($item['title'] ?? ''); ?>"></label>
            <label>Project URL<input type="text" name="website_url[]" value="<?php echo e($item['url'] ?? '#'); ?>"></label>
            <label>Image URL<input type="text" name="website_image[]" value="<?php echo e($item['image'] ?? ''); ?>"></label>
            <label>Upload Image<input type="file" name="website_image_file[]" accept="image/*"></label>
            <?php if (!empty($item['image'])): ?>
            <img src="../<?php echo e($item['image']); ?>" class="preview-img small" alt="">
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-add" data-add-portfolio="website">+ Add Website</button>

        <button type="submit" class="btn-save">Save Portfolio</button>
      </form>
    </section>

    <!-- SOCIAL & WHATSAPP -->
    <section class="admin-panel" id="social">
      <h2>Social & WhatsApp</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="social">
        <h3 class="admin-subhead">WhatsApp Float Button</h3>
        <p class="hint">Country code ke sath number likho, bina + / spaces (example: 923001234567).</p>
        <div class="grid-2">
          <label>WhatsApp Number<input type="text" name="whatsapp_number" value="<?php echo e($content['social']['whatsapp_number'] ?? ''); ?>" placeholder="923001234567"></label>
          <label>Default Message<input type="text" name="whatsapp_message" value="<?php echo e($content['social']['whatsapp_message'] ?? ''); ?>" placeholder="Hi, I would like to know more..."></label>
        </div>

        <h3 class="admin-subhead">Social Links</h3>
        <div class="grid-2">
          <label>Instagram URL<input type="text" name="instagram" value="<?php echo e($content['social']['instagram'] ?? ($content['footer']['social_instagram'] ?? '#')); ?>" placeholder="https://instagram.com/..."></label>
          <label>TikTok URL<input type="text" name="tiktok" value="<?php echo e($content['social']['tiktok'] ?? '#'); ?>" placeholder="https://tiktok.com/@..."></label>
          <label>Twitter / X URL<input type="text" name="twitter" value="<?php echo e($content['social']['twitter'] ?? ($content['footer']['social_twitter'] ?? '#')); ?>" placeholder="https://x.com/..."></label>
          <label>Facebook URL<input type="text" name="facebook" value="<?php echo e($content['social']['facebook'] ?? ($content['footer']['social_facebook'] ?? '#')); ?>" placeholder="https://facebook.com/..."></label>
          <label>YouTube URL<input type="text" name="youtube" value="<?php echo e($content['social']['youtube'] ?? ($content['footer']['social_youtube'] ?? '#')); ?>" placeholder="https://youtube.com/..."></label>
        </div>
        <button type="submit" class="btn-save">Save Social Links</button>
      </form>
    </section>

    <!-- FOOTER CTA -->
    <section class="admin-panel" id="footer_cta">
      <h2>Footer CTA</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="footer_cta">
        <label>Main Title<textarea name="title" rows="2"><?php echo e($content['footer_cta']['title']); ?></textarea></label>
        <div class="grid-2">
          <label>Partner Eyebrow<input type="text" name="partner_eyebrow" value="<?php echo e($content['footer_cta']['partner_eyebrow']); ?>"></label>
          <label>Phone<input type="text" name="phone" value="<?php echo e($content['footer_cta']['phone']); ?>"></label>
        </div>
        <label>Partners (comma separated)<textarea name="partners" rows="2"><?php echo e($content['footer_cta']['partners']); ?></textarea></label>
        <label>Phone Label<input type="text" name="phone_label" value="<?php echo e($content['footer_cta']['phone_label']); ?>"></label>
        <div class="grid-2">
          <label>Button Text<input type="text" name="button_text" value="<?php echo e($content['footer_cta']['button_text']); ?>"></label>
          <label>Button URL<input type="text" name="button_url" value="<?php echo e($content['footer_cta']['button_url']); ?>"></label>
          <label>ROAS Title<input type="text" name="roas_title" value="<?php echo e($content['footer_cta']['roas_title']); ?>"></label>
        </div>
        <label>ROAS Text<input type="text" name="roas_text" value="<?php echo e($content['footer_cta']['roas_text']); ?>"></label>
        <button type="submit" class="btn-save">Save Footer CTA</button>
      </form>
    </section>

    <!-- FOOTER -->
    <section class="admin-panel" id="footer">
      <h2>Footer Links</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="footer">
        <label>Solutions Eyebrow<input type="text" name="solutions_eyebrow" value="<?php echo e($content['footer']['solutions_eyebrow']); ?>"></label>
        <div class="grid-2">
          <label>Column 1 Links (one per line)<textarea name="links_col1" rows="3"><?php echo e($content['footer']['links_col1']); ?></textarea></label>
          <label>Column 2 Links<textarea name="links_col2" rows="3"><?php echo e($content['footer']['links_col2']); ?></textarea></label>
          <label>Column 3 Links<textarea name="links_col3" rows="3"><?php echo e($content['footer']['links_col3']); ?></textarea></label>
          <label>Column 4 Links<textarea name="links_col4" rows="3"><?php echo e($content['footer']['links_col4']); ?></textarea></label>
        </div>
        <label>Footer Nav (comma separated)<input type="text" name="nav" value="<?php echo e($content['footer']['nav']); ?>"></label>
        <label>Copyright Name<input type="text" name="copyright" value="<?php echo e($content['footer']['copyright']); ?>"></label>
        <div class="grid-2">
          <label>Terms URL<input type="text" name="terms_url" value="<?php echo e($content['footer']['terms_url']); ?>"></label>
          <label>Privacy URL<input type="text" name="privacy_url" value="<?php echo e($content['footer']['privacy_url']); ?>"></label>
          <label>Instagram URL<input type="text" name="social_instagram" value="<?php echo e($content['footer']['social_instagram']); ?>"></label>
          <label>Twitter URL<input type="text" name="social_twitter" value="<?php echo e($content['footer']['social_twitter']); ?>"></label>
          <label>Facebook URL<input type="text" name="social_facebook" value="<?php echo e($content['footer']['social_facebook']); ?>"></label>
          <label>YouTube URL<input type="text" name="social_youtube" value="<?php echo e($content['footer']['social_youtube']); ?>"></label>
        </div>
        <p class="hint">Tip: WhatsApp, Instagram, TikTok, Twitter — dedicated form <a href="#social">Social & WhatsApp</a> section mein edit karo.</p>
        <button type="submit" class="btn-save">Save Footer</button>
      </form>
    </section>

    <!-- SETTINGS -->
    <section class="admin-panel" id="settings">
      <h2>Change Password</h2>
      <form action="save.php" method="post" class="admin-form">
        <input type="hidden" name="section" value="password">
        <label>Current Password<input type="password" name="current_password" required></label>
        <label>New Password<input type="password" name="new_password" required minlength="6"></label>
        <label>Confirm New Password<input type="password" name="confirm_password" required minlength="6"></label>
        <button type="submit" class="btn-save">Update Password</button>
      </form>
    </section>
  </main>

  <script src="../assets/js/admin.js"></script>
</body>
</html>
