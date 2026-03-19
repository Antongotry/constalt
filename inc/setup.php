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
 * Prevent browser caching for frontend pages.
 */
function constalt_disable_frontend_cache(): void
{
    if (is_admin()) {
        return;
    }

    nocache_headers();
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
}
add_action('send_headers', 'constalt_disable_frontend_cache');

/**
 * Load theme assets.
 */
function constalt_enqueue_assets(): void
{
    wp_enqueue_style(
        'constalt-fonts',
        'https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'constalt-style',
        get_stylesheet_uri(),
        [],
        constalt_asset_version('/style.css')
    );

    wp_enqueue_style(
        'constalt-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['constalt-style', 'constalt-fonts'],
        constalt_asset_version('/assets/css/main.css')
    );

    wp_enqueue_script(
        'constalt-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        constalt_asset_version('/assets/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'constalt_enqueue_assets');
