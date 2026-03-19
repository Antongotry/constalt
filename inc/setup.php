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

// Request full-page cache bypass in common WordPress cache plugins.
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
 * Runtime cache buster used for deployment/debug sessions.
 */
function constalt_runtime_buster(): string
{
    return (string) time();
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
 * Load theme assets.
 */
function constalt_enqueue_assets(): void
{
    $runtime_buster = constalt_runtime_buster();
    $lenis_version = 'latest-' . $runtime_buster;
    $swiper_version = '11.2.6-' . $runtime_buster;

    wp_enqueue_style(
        'constalt-fonts',
        'https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap',
        [],
        $runtime_buster
    );

    wp_enqueue_style(
        'constalt-style',
        get_stylesheet_uri(),
        [],
        constalt_asset_version('/style.css') . '-' . $runtime_buster
    );

    wp_enqueue_style(
        'constalt-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['constalt-style', 'constalt-fonts'],
        constalt_asset_version('/assets/css/main.css') . '-' . $runtime_buster
    );

    wp_enqueue_style(
        'constalt-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        ['constalt-main'],
        $swiper_version
    );

    wp_enqueue_script(
        'constalt-lenis',
        'https://cdn.jsdelivr.net/npm/lenis@latest/dist/lenis.min.js',
        [],
        $lenis_version,
        true
    );

    wp_enqueue_script(
        'constalt-swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        $swiper_version,
        true
    );

    wp_enqueue_script(
        'constalt-main',
        get_template_directory_uri() . '/assets/js/main.js',
        ['constalt-lenis', 'constalt-swiper'],
        constalt_asset_version('/assets/js/main.js') . '-' . $runtime_buster,
        true
    );
}
add_action('wp_enqueue_scripts', 'constalt_enqueue_assets');
