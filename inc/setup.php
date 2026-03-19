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
 * Load theme assets.
 */
function constalt_enqueue_assets(): void
{
    wp_enqueue_style(
        'constalt-style',
        get_stylesheet_uri(),
        [],
        CONSTALT_THEME_VERSION
    );

    wp_enqueue_style(
        'constalt-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['constalt-style'],
        CONSTALT_THEME_VERSION
    );

    wp_enqueue_script(
        'constalt-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        CONSTALT_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'constalt_enqueue_assets');
