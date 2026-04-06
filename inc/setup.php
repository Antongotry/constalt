<?php
/**
 * Theme setup and asset loading.
 *
 * @package constalt
 */

declare(strict_types=1);

if (! defined('CONSTALT_THEME_VERSION')) {
    define('CONSTALT_THEME_VERSION', '0.1.0');
}

/**
 * Returns true for debug/development mode.
 */
function constalt_is_dev_mode(): bool
{
    return defined('WP_DEBUG') && WP_DEBUG;
}

/**
 * Absolute URL to a file under the uploads directory.
 *
 * Uses wp_upload_dir()['baseurl'] so paths stay correct on subdirectory installs,
 * multisite, and when WP_CONTENT_URL differs from the site root (unlike raw
 * "/wp-content/uploads/..." in CSS, which breaks on e.g. example.com/blog/).
 */
function constalt_uploads_url(string $relative_path): string
{
    $relative_path = ltrim(str_replace('\\', '/', $relative_path), '/');

    if (! function_exists('wp_upload_dir')) {
        return content_url('uploads/' . $relative_path);
    }

    $upload_dir = wp_upload_dir();

    if (! empty($upload_dir['error'])) {
        return content_url('uploads/' . $relative_path);
    }

    return trailingslashit($upload_dir['baseurl']) . $relative_path;
}

/**
 * Registers :root CSS variables with full url(...) values for theme backgrounds.
 * Compiled SCSS references var(--constalt-media-*) so assets resolve on any domain.
 */
function constalt_enqueue_uploads_css_variables(): void
{
    $defs = [
        '--constalt-media-hero-desc-fallback' => '2026/03/hero-desc_result-scaled.webp',
        '--constalt-media-hero-mobile' => '2026/03/Frame-2087325716_result.webp',
        '--constalt-media-about-main' => '2026/03/phonje_result-scaled.webp',
        '--constalt-media-about-mobile' => '2026/03/Frame-2087325717_result.webp',
        '--constalt-media-contact-panel' => '2026/03/Frame-2087325608_result.webp',
        '--constalt-media-expert-photo' => '2026/03/phot2_result.webp',
        '--constalt-media-insight-maze' => '2026/03/minos-2_result.webp',
        '--constalt-media-svc-finance' => '2026/03/b3-ima_result.webp',
        '--constalt-media-svc-corporate' => '2026/03/b3-image-2_result.webp',
        '--constalt-media-svc-due' => '2026/03/b3-image-3_result.webp',
        '--constalt-media-svc-legal' => '2026/03/b3-image-4_result.webp',
        '--constalt-media-trust-fad' => '2026/03/fad_result-scaled.webp',
        '--constalt-media-trust-photo' => '2026/03/ChatGPT-Image-17-%D0%B1%D0%B5%D1%80.-2026-%D1%80.-20_58_12-1_result.webp',
    ];

    $chunks = [];

    foreach ($defs as $var => $rel) {
        $chunks[] = sprintf(
            '%s:url(%s)',
            $var,
            esc_url(constalt_uploads_url($rel))
        );
    }

    wp_add_inline_style(
        'constalt-main',
        ':root{' . implode(';', $chunks) . ';}'
    );
}

// Request cache bypass only while debugging.
if (constalt_is_dev_mode()) {
    if (! defined('DONOTCACHEPAGE')) {
        define('DONOTCACHEPAGE', true);
    }

    if (! defined('DONOTCACHEOBJECT')) {
        define('DONOTCACHEOBJECT', true);
    }

    if (! defined('DONOTCACHEDB')) {
        define('DONOTCACHEDB', true);
    }

    if (! defined('DONOTMINIFY')) {
        define('DONOTMINIFY', true);
    }
}

/**
 * Configure theme features.
 */
function constalt_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );

    register_nav_menus(
        [
            'primary' => esc_html__('Primary Menu', 'constalt'),
        ]
    );
}
add_action('after_setup_theme', 'constalt_theme_setup');

/**
 * Get asset version based on file modification time.
 */
function constalt_asset_version(string $relative_path): string
{
    $file_path = get_template_directory() . $relative_path;

    if (! file_exists($file_path)) {
        return CONSTALT_THEME_VERSION;
    }

    $modified_time = filemtime($file_path);

    return $modified_time ? (string) $modified_time : CONSTALT_THEME_VERSION;
}

/**
 * Runtime cache buster for frontend assets.
 */
function constalt_runtime_buster(): string
{
    return (string) time();
}

/**
 * Append runtime buster suffix to asset version.
 */
function constalt_version_with_buster(string $version, string $runtime_buster): string
{
    if ($runtime_buster === '') {
        return $version;
    }

    return $version . '-' . $runtime_buster;
}

/**
 * Prevent browser caching for frontend pages.
 */
function constalt_disable_frontend_cache(): void
{
    if (is_admin()) {
        return;
    }

    nocache_headers();
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
    header('Surrogate-Control: no-store');
    header('X-Accel-Expires: 0');
    header('X-LiteSpeed-Cache-Control: no-cache');
    header('Vary: *');
}
add_action('send_headers', 'constalt_disable_frontend_cache');

/**
 * Resource hints: preconnect to external origins so the browser
 * starts DNS + TLS early, before it encounters the stylesheet links.
 */
function constalt_resource_hints(): void
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>' . "\n";
}
add_action('wp_head', 'constalt_resource_hints', 1);

/**
 * Critical inline CSS rendered before any external stylesheet.
 * Covers body, header and hero basics so the page never flashes
 * unstyled content while external CSS files are still loading.
 */
function constalt_critical_css(): void
{
    ?>
    <style id="constalt-critical">
    *,*::before,*::after{box-sizing:border-box}
    html,body{margin:0;padding:0;min-height:100%;overflow-x:hidden;background:#051120;color:#f1f5ff;font-family:"Inter Tight","Segoe UI",-apple-system,BlinkMacSystemFont,sans-serif}
    body{font-size:1.1111111111vw;line-height:1.5}
    @media(max-width:767px){body{font-size:4.1025641026vw}}
    .site{min-height:100vh}
    .site-header{width:100%;position:fixed;left:0;top:0.6944444444vw;z-index:200;background:transparent;border:0;box-shadow:none}
    .site-header__inner{width:94.4444444444vw;max-width:calc(100% - 2.7777777778vw);margin-inline:auto;height:6.1111111111vw;padding-inline:1.3888888889vw;display:flex;align-items:center;justify-content:space-between;border:0;border-radius:0;background:linear-gradient(180deg,rgba(25,36,50,.62) 0%,rgba(5,17,32,.52) 100%);box-shadow:0 .4166666667vw 1.5277777778vw rgba(3,12,24,.28);backdrop-filter:blur(1.8055555556vw);-webkit-backdrop-filter:blur(1.8055555556vw)}
    .site-header__line{display:none}
    .site-header__logo-link{display:inline-flex;height:100%;align-items:center}
    .site-header__logo{display:block;width:auto;height:4.1666666667vw;max-width:18.0555555556vw}
    .site-header__actions{display:inline-flex;align-items:center;gap:12.8472222222vw}
    .site-header__nav{display:inline-flex;align-items:center;gap:1.6666666667vw}
    .site-header__nav-link{color:#fff;font-family:"Inter Tight","Segoe UI",-apple-system,BlinkMacSystemFont,sans-serif;font-size:0.9722222222vw;font-weight:400;line-height:140%;text-decoration:none;white-space:nowrap}
    .site-header__cta{display:inline-flex;align-items:center;justify-content:center;gap:0.6944444444vw;padding:0.8333333333vw 1.6666666667vw;border-radius:6.9444444444vw;background:linear-gradient(339deg,#c7c7c7 11.9%,#f1f1f1 84.59%);color:#051120;font-size:0.9722222222vw;font-weight:400;line-height:140%;text-decoration:none;white-space:nowrap}
    .site-header__burger,.site-header__mobile-menu{display:none}
    a{color:inherit;text-decoration:none}
    @media(max-width:1024px){
      .site-header{top:2.6666666667vw}
      .site-header__inner,.site-header__line{width:94.6666666667vw;max-width:calc(100% - 5.3333333333vw)}
      .site-header__inner{height:15.4666666667vw;padding-inline:3.2vw;background:linear-gradient(180deg,rgba(25,36,50,.68) 0%,rgba(5,17,32,.58) 100%);box-shadow:0 1.0666666667vw 4.2666666667vw rgba(3,12,24,.3);backdrop-filter:blur(3.2vw);-webkit-backdrop-filter:blur(3.2vw)}
      .site-header__logo{width:auto;height:11.2vw;max-width:48vw}
      .site-header__actions{display:none}
      .site-header__burger{display:inline-flex;width:6.9333333333vw;height:4.2666666667vw;border:0;background:transparent;padding:0;flex-direction:column;justify-content:space-between;cursor:pointer;position:relative;z-index:230}
      .site-header__burger-line{width:100%;height:1px;background:#fff;border-radius:0}
    }
    </style>
    <?php
}
add_action('wp_head', 'constalt_critical_css', 2);

/**
 * Load theme assets.
 */
function constalt_enqueue_assets(): void
{
    $runtime_buster = constalt_runtime_buster();
    $lenis_version = constalt_version_with_buster('latest', $runtime_buster);
    $gsap_version = constalt_version_with_buster('3.13.0', $runtime_buster);

    wp_enqueue_style(
        'constalt-style',
        get_stylesheet_uri(),
        [],
        constalt_version_with_buster(constalt_asset_version('/style.css'), $runtime_buster)
    );

    wp_enqueue_style(
        'constalt-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['constalt-style'],
        constalt_version_with_buster(constalt_asset_version('/assets/css/main.css'), $runtime_buster)
    );

    constalt_enqueue_uploads_css_variables();

    wp_enqueue_style(
        'constalt-fonts',
        'https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;600;700&display=swap',
        [],
        constalt_version_with_buster(CONSTALT_THEME_VERSION, $runtime_buster)
    );

    wp_enqueue_script(
        'constalt-lenis',
        'https://cdn.jsdelivr.net/npm/lenis@latest/dist/lenis.min.js',
        [],
        $lenis_version,
        true
    );

    wp_enqueue_script(
        'constalt-gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js',
        [],
        $gsap_version,
        true
    );

    wp_enqueue_script(
        'constalt-gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js',
        ['constalt-gsap'],
        $gsap_version,
        true
    );

    wp_enqueue_script(
        'constalt-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['constalt-lenis', 'constalt-gsap-scrolltrigger'],
        constalt_version_with_buster(constalt_asset_version('/assets/js/main.js'), $runtime_buster),
        true
    );

    wp_localize_script(
        'constalt-main',
        'constaltFormConfig',
        [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('constalt_form_submit'),
        ]
    );
}
add_action('wp_enqueue_scripts', 'constalt_enqueue_assets');

/**
 * Prevent LiteSpeed Cache from deferring critical stylesheets
 * and mark Google Fonts for async loading.
 */
function constalt_optimize_style_loading(string $tag, string $handle): string
{
    $critical = ['constalt-style', 'constalt-main'];

    if (in_array($handle, $critical, true)) {
        $tag = str_replace(' href=', ' data-no-optimize="1" href=', $tag);
    }

    $async_handles = ['constalt-fonts'];

    if (in_array($handle, $async_handles, true)) {
        $tag = str_replace(
            "media='all'",
            "media='print' onload=\"this.media='all'\"",
            $tag
        );
    }

    return $tag;
}
add_filter('style_loader_tag', 'constalt_optimize_style_loading', 10, 2);

/**
 * Normalize request path relative to site home path.
 */
function constalt_current_request_path(): string
{
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $request_path = trim((string) wp_parse_url((string) $request_uri, PHP_URL_PATH), '/');
    $home_path = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');

    if ($home_path !== '' && str_starts_with($request_path, $home_path . '/')) {
        $request_path = substr($request_path, strlen($home_path) + 1);
    } elseif ($request_path === $home_path) {
        $request_path = '';
    }

    return trim((string) $request_path, '/');
}

/**
 * Force /blog/ route to render posts archive template, independent from WP settings.
 */
function constalt_force_blog_route_template(): void
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $path = constalt_current_request_path();

    if ($path !== 'blog' && ! preg_match('#^blog/page/([0-9]+)/?$#', $path, $matches)) {
        return;
    }

    $paged = isset($matches[1]) ? max(1, (int) $matches[1]) : 1;

    set_query_var('paged', $paged);
    set_query_var('page', $paged);

    status_header(200);
    nocache_headers();

    $template = locate_template('page-blog.php');

    if ($template) {
        include $template;
        exit;
    }
}
add_action('template_redirect', 'constalt_force_blog_route_template', 0);

/**
 * Force /contacts/ route to render static contacts template.
 */
function constalt_force_contacts_route_template(): void
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    if (constalt_current_request_path() !== 'contacts') {
        return;
    }

    status_header(200);
    nocache_headers();

    $template = locate_template('page-contacts.php');

    if ($template) {
        include $template;
        exit;
    }
}
add_action('template_redirect', 'constalt_force_contacts_route_template', 1);

/**
 * Force /privacy-policy/ route to render static privacy policy template.
 */
function constalt_force_privacy_policy_route_template(): void
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return;
    }

    $path = constalt_current_request_path();

    if ($path !== 'privacy-policy') {
        return;
    }

    status_header(200);
    nocache_headers();

    $template = locate_template('page-privacy-policy.php');

    if ($template) {
        include $template;
        exit;
    }
}
add_action('template_redirect', 'constalt_force_privacy_policy_route_template', 2);

/**
 * Preload the mobile LCP background image so the hero paints quickly.
 */
function constalt_preload_lcp_image(): void
{
    $mobile_hero = constalt_uploads_url('2026/03/Frame-2087325716_result.webp');
    $desktop_hero = constalt_uploads_url('2026/03/hero-desc_result-scaled.webp');

    echo '<link rel="preload" as="image" href="' . esc_url($mobile_hero) . '" media="(max-width: 1024px)">' . "\n";
    echo '<link rel="preload" as="image" href="' . esc_url($desktop_hero) . '" media="(min-width: 1025px)">' . "\n";
}
add_action('wp_head', 'constalt_preload_lcp_image', 3);

/**
 * Set long-lived cache headers for theme static assets in production.
 */
function constalt_static_cache_headers(): void
{
    if (constalt_is_dev_mode() || is_admin()) {
        return;
    }

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    if (preg_match('/\.(css|js|svg|webp|woff2?|png|jpe?g|gif|mp4)(\?|$)/i', $request_uri)) {
        header('Cache-Control: public, max-age=31536000, immutable');
        header_remove('Pragma');
        header_remove('Expires');
    }
}
add_action('send_headers', 'constalt_static_cache_headers', 1);

/**
 * Submit all site forms to admin email from admin email.
 */
function constalt_handle_form_submit(): void
{
    check_ajax_referer('constalt_form_submit', 'nonce');

    $admin_email = sanitize_email((string) get_option('admin_email'));

    if ($admin_email === '') {
        wp_send_json_error(
            ['message' => esc_html__('Admin email is not configured.', 'constalt')],
            500
        );
    }

    $name = isset($_POST['name']) ? sanitize_text_field((string) wp_unslash($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field((string) wp_unslash($_POST['phone'])) : '';
    $question = isset($_POST['question']) ? sanitize_textarea_field((string) wp_unslash($_POST['question'])) : '';
    $service = isset($_POST['service']) ? sanitize_text_field((string) wp_unslash($_POST['service'])) : '';
    $consent = isset($_POST['consent']) ? (string) wp_unslash($_POST['consent']) : '';

    $phone_digits = preg_replace('/\D+/', '', $phone);
    $is_phone_valid = is_string($phone_digits) && preg_match('/^380\d{9}$/', $phone_digits) === 1;

    if (! $is_phone_valid) {
        wp_send_json_error(
            ['message' => esc_html__('Введіть номер у форматі +380XXXXXXXXX.', 'constalt')],
            422
        );
    }

    $phone = '+' . $phone_digits;

    if ($consent === '') {
        wp_send_json_error(
            ['message' => esc_html__('Потрібно підтвердити згоду.', 'constalt')],
            422
        );
    }

    $subject_parts = [esc_html__('Нова заявка з сайту', 'constalt')];

    if ($service !== '') {
        $subject_parts[] = $service;
    }

    $subject = implode(' — ', $subject_parts);

    $message_lines = [
        'Імʼя: ' . ($name !== '' ? $name : '—'),
        'Телефон: ' . $phone,
        'Запитання: ' . ($question !== '' ? $question : '—'),
        'Послуга: ' . ($service !== '' ? $service : '—'),
        'Сторінка: ' . esc_url_raw((string) wp_get_referer()),
        'Дата: ' . wp_date('Y-m-d H:i:s'),
    ];

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        sprintf('From: %s <%s>', wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $admin_email),
        sprintf('Reply-To: %s', $admin_email),
    ];

    $sent = wp_mail($admin_email, $subject, implode("\n", $message_lines), $headers);

    if (! $sent) {
        wp_send_json_error(
            ['message' => esc_html__('Не вдалося надіслати форму.', 'constalt')],
            500
        );
    }

    wp_send_json_success(['message' => esc_html__('Форму надіслано.', 'constalt')]);
}
add_action('wp_ajax_constalt_submit_form', 'constalt_handle_form_submit');
add_action('wp_ajax_nopriv_constalt_submit_form', 'constalt_handle_form_submit');
