<?php
/**
 * Front-page header.
 *
 * @package constalt
 */

declare(strict_types=1);

?>
<header class="site-header">
    <div class="site-header__inner">
        <a class="site-header__logo-link" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Home', 'constalt'); ?>">
            <img
                class="site-header__logo"
                src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-audit-consulting.svg'); ?>"
                alt="Audit Consulting"
                loading="eager"
                decoding="async"
            >
        </a>
        <div class="site-header__actions">
            <nav class="site-header__nav" aria-label="<?php esc_attr_e('Primary', 'constalt'); ?>">
                <a class="site-header__nav-link" href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
                <a class="site-header__nav-link" href="<?php echo esc_url(home_url('/#services')); ?>">Послуги</a>
                <a class="site-header__nav-link" href="<?php echo esc_url(home_url('/#about')); ?>">Про нас</a>
                <a class="site-header__nav-link" href="<?php echo esc_url(home_url('/blog/')); ?>">Новини</a>
                <a class="site-header__nav-link" href="<?php echo esc_url(home_url('/contacts/')); ?>">Контакти</a>
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
                <a class="site-header__mobile-link" href="<?php echo esc_url(home_url('/')); ?>" data-header-menu-link>Головна</a>
                <a class="site-header__mobile-link" href="<?php echo esc_url(home_url('/#services')); ?>" data-header-menu-link>Послуги</a>
                <a class="site-header__mobile-link" href="<?php echo esc_url(home_url('/#about')); ?>" data-header-menu-link>Про нас</a>
                <a class="site-header__mobile-link" href="<?php echo esc_url(home_url('/contacts/')); ?>" data-header-menu-link>Контакти</a>
                <a class="site-header__mobile-link" href="<?php echo esc_url(home_url('/blog/')); ?>" data-header-menu-link>Новини</a>
            </nav>

            <div class="site-header__mobile-contacts">
                <a class="site-header__mobile-phone" href="tel:+380751955002">+38 075 195 50 02</a>
                <a class="site-header__mobile-mail" href="<?php echo esc_url('mailto:office@audit-consulting.org'); ?>">office@audit-consulting.org</a>
                <p class="site-header__mobile-address">м. Київ, вул. Шота Руставелі, буд. 24, оф. 18</p>
            </div>

            <a class="site-header__mobile-cta" href="#" data-site-popup-open data-popup-key="consultation-general" data-header-menu-link>
                Отримати консультацію
            </a>

            <div class="site-header__mobile-socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                <a class="site-header__mobile-social" href="#" aria-label="Telegram">
                    <svg class="site-header__mobile-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M20.76 4.2 3.95 10.68c-1.15.47-1.14 1.11-.2 1.39l4.31 1.34 9.96-6.28c.47-.29.9-.13.55.18l-8.07 7.29-.3 4.53c.44 0 .64-.2.89-.44l2.15-2.09 4.47 3.3c.83.46 1.42.22 1.63-.77l2.86-13.48c.31-1.21-.47-1.76-1.34-1.37z"/>
                    </svg>
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Instagram">
                    <svg class="site-header__mobile-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.86 1.43a1.34 1.34 0 1 1 0 2.68 1.34 1.34 0 0 1 0-2.68zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9A3.1 3.1 0 1 0 12 15.1 3.1 3.1 0 0 0 12 8.9z"/>
                    </svg>
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Facebook">
                    <svg class="site-header__mobile-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M13.5 22v-8h2.6l.4-3h-3V9.1c0-.86.24-1.45 1.48-1.45H16.6V5a22.2 22.2 0 0 0-2.46-.13c-2.44 0-4.1 1.49-4.1 4.22V11H7.4v3h2.64v8h3.46z"/>
                    </svg>
                </a>
                <a class="site-header__mobile-social" href="#" aria-label="Viber">
                    <svg class="site-header__mobile-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M11.7 3C7 3 3.4 6.2 3.4 10.4c0 2.4 1.2 4.6 3.2 6l-.7 3 3.1-1.7c.9.2 1.8.3 2.7.3 4.7 0 8.3-3.2 8.3-7.4S16.4 3 11.7 3zm4.3 9.7c-.2.5-1 .9-1.4 1-.4.1-.9.1-1.4-.1-.3-.1-.7-.2-1.2-.4-2.1-.9-3.5-3.2-3.6-3.3-.1-.1-.9-1.2-.9-2.2 0-1 .5-1.5.7-1.7.2-.2.4-.2.5-.2h.4c.1 0 .3 0 .4.3.2.5.6 1.6.6 1.7.1.1.1.3 0 .4-.1.1-.1.3-.3.4l-.2.3c-.1.1-.1.2 0 .4.1.1.5.9 1.1 1.4.8.7 1.4 1 1.6 1.1.2.1.3.1.5-.1.1-.1.5-.6.6-.8.2-.2.3-.2.5-.1.2.1 1.2.6 1.4.7.2.1.4.2.4.3.1.2.1.8-.1 1.3z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="site-header__line" aria-hidden="true"></div>
</header>
