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
            <a class="site-header__cta" href="#" data-site-popup-open data-popup-key="consultation-general">
                Отримати консультацію
            </a>
        </div>
        <button class="site-header__burger" type="button" aria-label="<?php esc_attr_e('Відкрити меню', 'constalt'); ?>" aria-controls="site-header-mobile-menu" aria-expanded="false" data-header-menu-toggle>
            <span class="site-header__burger-line" aria-hidden="true"></span>
            <span class="site-header__burger-line" aria-hidden="true"></span>
            <span class="site-header__burger-line" aria-hidden="true"></span>
        </button>
    </div>
    <div class="site-header__mobile-menu" id="site-header-mobile-menu" hidden data-header-mobile-menu>
        <button class="site-header__mobile-backdrop" type="button" aria-label="<?php esc_attr_e('Закрити меню', 'constalt'); ?>" data-header-menu-close></button>
        <div class="site-header__mobile-panel">
            <nav class="site-header__mobile-nav" aria-label="<?php esc_attr_e('Мобільна навігація', 'constalt'); ?>">
                <a class="site-header__mobile-link" href="#home" data-header-menu-link>Головна</a>
                <a class="site-header__mobile-link" href="#services" data-header-menu-link>Послуги</a>
                <a class="site-header__mobile-link" href="#about" data-header-menu-link>Про нас</a>
                <a class="site-header__mobile-link" href="#contacts" data-header-menu-link>Контакти</a>
                <a class="site-header__mobile-link" href="#news" data-header-menu-link>Новини</a>
            </nav>

            <div class="site-header__mobile-contacts">
                <a class="site-header__mobile-phone" href="tel:+380999999999">+38 (099) 999 99 99</a>
                <a class="site-header__mobile-mail" href="mailto:info@gmail.com">info@gmail.com</a>
            </div>

            <a class="site-header__mobile-cta" href="#" data-site-popup-open data-popup-key="consultation-general" data-header-menu-link>
                Отримати консультацію
            </a>

            <div class="site-header__mobile-socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                <a class="site-header__mobile-social" href="#" aria-label="Telegram">
                    <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/tg.svg" alt="">
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Instagram">
                    <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/insta.svg" alt="">
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Facebook">
                    <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/facebook.svg" alt="">
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Viber">
                    <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/viber.svg" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="site-header__line" aria-hidden="true"></div>
</header>
