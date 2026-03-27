<?php
/**
 * Site footer template.
 *
 * @package constalt
 */
?>
<footer class="site-footer">
    <div class="site-footer__container">
        <div class="site-footer__line" aria-hidden="true"></div>

        <div class="site-footer__main">
            <a class="site-footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('На головну', 'constalt'); ?>">
                <img
                    class="site-footer__logo"
                    src="<?php echo esc_url('https://audit-consulting.org/wp-content/uploads/2026/03/%D0%A1%D1%96%D1%80%D0%B8%D0%B9-1.svg'); ?>"
                    alt="Audit Consulting"
                    loading="lazy"
                    decoding="async"
                >
            </a>

            <nav class="site-footer__column site-footer__column--nav" aria-label="<?php esc_attr_e('Навігація', 'constalt'); ?>">
                <p class="site-footer__label">Навігація</p>
                <a class="site-footer__link" href="#page">Головна</a>
                <a class="site-footer__link" href="#services">Послуги</a>
                <a class="site-footer__link" href="#about">Про нас</a>
                <a class="site-footer__link" href="<?php echo esc_url(home_url('/contacts/')); ?>">Контакти</a>
                <a class="site-footer__link" href="#news">Новини</a>

                <div class="site-footer__contact-block site-footer__contact-block--secondary site-footer__contact-block--address site-footer__contact-block--desktop-only">
                    <p class="site-footer__label">Адреса</p>
                    <p class="site-footer__text">м. Київ, вул. Шота Руставелі, буд. 24, оф. 18</p>
                </div>
            </nav>

            <div class="site-footer__column site-footer__column--directions">
                <p class="site-footer__label">Напрямки</p>
                <a class="site-footer__link" href="#services">Фінансовий консалтинг</a>
                <a class="site-footer__link" href="#services">Корпоративне управління</a>
                <a class="site-footer__link" href="#services">Due Diligence та інвестиційний супровід</a>
                <a class="site-footer__link" href="#services">Юридична архітектура та захист активів</a>

                <div class="site-footer__contact-block site-footer__contact-block--secondary site-footer__contact-block--schedule site-footer__contact-block--desktop-only">
                    <p class="site-footer__label">Графік роботи</p>
                    <p class="site-footer__text">Пн-Пт з 9.00 до 18.00</p>
                </div>
            </div>

            <div class="site-footer__aside">
                <a class="site-footer__cta" href="#" data-site-popup-open data-popup-key="consultation-general">
                    <span class="site-footer__cta-label">Отримати консультацію</span>
                    <span class="site-footer__cta-icon" aria-hidden="true">
                        <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.163 12.489L12.489 4.163" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.857 4.163H12.489V11.795" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>

                <div class="site-footer__contact-block site-footer__contact-block--phone">
                    <p class="site-footer__label">Телефон</p>
                    <a class="site-footer__contact-value site-footer__contact-value--phone" href="tel:+380751955002">+38 075 195 50 02</a>
                </div>

                <div class="site-footer__socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                    <a class="site-footer__social" href="#" aria-label="Telegram">
                        <svg class="site-footer__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M20.76 4.2 3.95 10.68c-1.15.47-1.14 1.11-.2 1.39l4.31 1.34 9.96-6.28c.47-.29.9-.13.55.18l-8.07 7.29-.3 4.53c.44 0 .64-.2.89-.44l2.15-2.09 4.47 3.3c.83.46 1.42.22 1.63-.77l2.86-13.48c.31-1.21-.47-1.76-1.34-1.37z"/>
                        </svg>
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Instagram">
                        <svg class="site-footer__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.86 1.43a1.34 1.34 0 1 1 0 2.68 1.34 1.34 0 0 1 0-2.68zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9A3.1 3.1 0 1 0 12 15.1 3.1 3.1 0 0 0 12 8.9z"/>
                        </svg>
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Facebook">
                        <svg class="site-footer__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M13.5 22v-8h2.6l.4-3h-3V9.1c0-.86.24-1.45 1.48-1.45H16.6V5a22.2 22.2 0 0 0-2.46-.13c-2.44 0-4.1 1.49-4.1 4.22V11H7.4v3h2.64v8h3.46z"/>
                        </svg>
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Viber">
                        <svg class="site-footer__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M11.7 3C7 3 3.4 6.2 3.4 10.4c0 2.4 1.2 4.6 3.2 6l-.7 3 3.1-1.7c.9.2 1.8.3 2.7.3 4.7 0 8.3-3.2 8.3-7.4S16.4 3 11.7 3zm4.3 9.7c-.2.5-1 .9-1.4 1-.4.1-.9.1-1.4-.1-.3-.1-.7-.2-1.2-.4-2.1-.9-3.5-3.2-3.6-3.3-.1-.1-.9-1.2-.9-2.2 0-1 .5-1.5.7-1.7.2-.2.4-.2.5-.2h.4c.1 0 .3 0 .4.3.2.5.6 1.6.6 1.7.1.1.1.3 0 .4-.1.1-.1.3-.3.4l-.2.3c-.1.1-.1.2 0 .4.1.1.5.9 1.1 1.4.8.7 1.4 1 1.6 1.1.2.1.3.1.5-.1.1-.1.5-.6.6-.8.2-.2.3-.2.5-.1.2.1 1.2.6 1.4.7.2.1.4.2.4.3.1.2.1.8-.1 1.3z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="site-footer__mobile-meta-row">
                <div class="site-footer__contact-block site-footer__contact-block--address">
                    <p class="site-footer__label">Адреса</p>
                    <p class="site-footer__text">м. Київ, вул. Шота Руставелі, буд. 24, оф. 18</p>
                </div>

                <div class="site-footer__contact-block site-footer__contact-block--schedule">
                    <p class="site-footer__label">Графік роботи</p>
                    <p class="site-footer__text">Пн-Пт з 9.00 до 18.00</p>
                </div>
            </div>
        </div>

        <div class="site-footer__line" aria-hidden="true"></div>

        <div class="site-footer__bottom">
            <a class="site-footer__meta-link site-footer__meta-link--privacy" href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Політика конфіденційності</a>
            <a class="site-footer__meta-link site-footer__meta-link--offer" href="#offer">Договір оферти</a>
            <a class="site-footer__meta-link site-footer__meta-link--credit" href="https://www.instagram.com/gleb_kpk?igsh=bDRoZWpyajJxMjBw" target="_blank" rel="noopener noreferrer">Розроблено в Artko</a>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
