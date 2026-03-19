<?php
/**
 * Front-page header.
 *
 * @package constalt
 */

declare(strict_types=1);

$asset_buster = (string) time();
?>
<header class="site-header">
    <div class="site-header__inner">
        <a class="site-header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Home', 'constalt'); ?>">
            <img
                class="site-header__logo"
                src="<?php echo esc_url('https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/logo-white.svg?v=' . $asset_buster); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                width="221"
                height="26"
                loading="eager"
                decoding="async"
            >
        </a>
        <div class="site-header__actions">
            <nav class="site-header__nav" aria-label="<?php esc_attr_e('Primary', 'constalt'); ?>">
                <a class="site-header__nav-link" href="#home">Головна</a>
                <a class="site-header__nav-link" href="#services">Послуги</a>
                <a class="site-header__nav-link" href="#about">Про нас</a>
                <a class="site-header__nav-link" href="#contacts">Контакти</a>
            </nav>
            <a class="site-header__cta" href="#contact">
                Отримати консультацію
            </a>
        </div>
    </div>
    <div class="site-header__line" aria-hidden="true"></div>
</header>
