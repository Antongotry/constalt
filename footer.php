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
                <img class="site-footer__logo" src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/Audit-consulting.svg" alt="Audit consulting">
            </a>

            <nav class="site-footer__column site-footer__column--nav" aria-label="<?php esc_attr_e('Навігація', 'constalt'); ?>">
                <p class="site-footer__label">Навігація</p>
                <a class="site-footer__link" href="#page">Головна</a>
                <a class="site-footer__link" href="#services">Послуги</a>
                <a class="site-footer__link" href="#about">Про нас</a>
                <a class="site-footer__link" href="#contact">Контакти</a>
                <a class="site-footer__link" href="#news">Новини</a>
            </nav>

            <div class="site-footer__column site-footer__column--directions">
                <p class="site-footer__label">Напрямки</p>
                <a class="site-footer__link" href="#services">Фінансовий консалтинг</a>
                <a class="site-footer__link" href="#services">Корпоративне управління</a>
                <a class="site-footer__link" href="#services">Due Diligence та інвестиційний супровід</a>
                <a class="site-footer__link" href="#services">Юридична архітектура та захист активів</a>
            </div>

            <div class="site-footer__column site-footer__column--contacts">
                <div class="site-footer__contact-block site-footer__contact-block--phone">
                    <p class="site-footer__label">Телефон</p>
                    <a class="site-footer__contact-value site-footer__contact-value--phone" href="tel:+380999999999">+38 (099) 999 99 99</a>
                </div>

                <div class="site-footer__contact-block">
                    <p class="site-footer__label">Пошта</p>
                    <a class="site-footer__contact-value site-footer__contact-value--mail" href="mailto:info@gmail.com">info@gmail.com</a>
                </div>

                <div class="site-footer__contact-block site-footer__contact-block--address">
                    <p class="site-footer__label">Адреса</p>
                    <p class="site-footer__text">назва Вулиці, 123, Київ</p>
                </div>

                <div class="site-footer__contact-block site-footer__contact-block--schedule">
                    <p class="site-footer__label">Графік роботи</p>
                    <p class="site-footer__text">Пн-Пт з 9.00 до 18.00</p>
                </div>
            </div>

            <div class="site-footer__aside">
                <a class="site-footer__cta" href="#contact">
                    <span class="site-footer__cta-label">Отримати консультацію</span>
                    <span class="site-footer__cta-icon" aria-hidden="true">
                        <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.163 12.489L12.489 4.163" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4.857 4.163H12.489V11.795" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>

                <div class="site-footer__socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                    <a class="site-footer__social" href="#" aria-label="Telegram">
                        <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/tg.svg" alt="">
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Instagram">
                        <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/insta.svg" alt="">
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Facebook">
                        <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/facebook.svg" alt="">
                    </a>
                    <a class="site-footer__social" href="#" aria-label="Viber">
                        <img src="https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/viber.svg" alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="site-footer__line" aria-hidden="true"></div>

        <div class="site-footer__bottom">
            <a class="site-footer__meta-link site-footer__meta-link--privacy" href="#privacy">Політика конфіденційності</a>
            <a class="site-footer__meta-link site-footer__meta-link--offer" href="#offer">Договір оферти</a>
            <a class="site-footer__meta-link site-footer__meta-link--credit" href="https://www.instagram.com/gleb_kpk?igsh=bDRoZWpyajJxMjBw" target="_blank" rel="noopener noreferrer">Розроблено в Artko</a>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
