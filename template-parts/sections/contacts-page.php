<?php
/**
 * Contacts page section.
 *
 * @package constalt
 */

declare(strict_types=1);

?>
<section class="contacts-page" id="contacts">
    <div class="contacts-page__container">
        <div class="contacts-page__layout">
            <div class="contacts-page__left">
                <div class="contacts-page__marker" aria-label="<?php esc_attr_e('Розділ контакти', 'constalt'); ?>">
                    <span class="contacts-page__marker-dot" aria-hidden="true"></span>
                    <span class="contacts-page__marker-text">Контакти</span>
                </div>

                <h1 class="contacts-page__title">Способи зв'язку</h1>

                <div class="contacts-page__info-grid">
                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label">Телефон</p>
                        <a class="contacts-page__info-value" href="tel:+380999999999">+38 (099) 999 99 99</a>
                    </div>

                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label">Пошта</p>
                        <a class="contacts-page__info-value" href="mailto:info@gmail.com">info@gmail.com</a>
                    </div>

                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label">Адреса</p>
                        <p class="contacts-page__info-value">назва Вулиці, 123, Київ</p>
                    </div>

                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label">Графік роботи</p>
                        <p class="contacts-page__info-value">Пн-Пт з 9.00 до 18.00</p>
                    </div>
                </div>

                <div class="contacts-page__socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                    <a class="contacts-page__social" href="#" aria-label="Telegram">
                        <svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M20.76 4.2 3.95 10.68c-1.15.47-1.14 1.11-.2 1.39l4.31 1.34 9.96-6.28c.47-.29.9-.13.55.18l-8.07 7.29-.3 4.53c.44 0 .64-.2.89-.44l2.15-2.09 4.47 3.3c.83.46 1.42.22 1.63-.77l2.86-13.48c.31-1.21-.47-1.76-1.34-1.37z"/>
                        </svg>
                    </a>
                    <a class="contacts-page__social" href="#" aria-label="Instagram">
                        <svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.86 1.43a1.34 1.34 0 1 1 0 2.68 1.34 1.34 0 0 1 0-2.68zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9A3.1 3.1 0 1 0 12 15.1 3.1 3.1 0 0 0 12 8.9z"/>
                        </svg>
                    </a>
                    <a class="contacts-page__social" href="#" aria-label="Viber">
                        <svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M11.7 3C7 3 3.4 6.2 3.4 10.4c0 2.4 1.2 4.6 3.2 6l-.7 3 3.1-1.7c.9.2 1.8.3 2.7.3 4.7 0 8.3-3.2 8.3-7.4S16.4 3 11.7 3zm4.3 9.7c-.2.5-1 .9-1.4 1-.4.1-.9.1-1.4-.1-.3-.1-.7-.2-1.2-.4-2.1-.9-3.5-3.2-3.6-3.3-.1-.1-.9-1.2-.9-2.2 0-1 .5-1.5.7-1.7.2-.2.4-.2.5-.2h.4c.1 0 .3 0 .4.3.2.5.6 1.6.6 1.7.1.1.1.3 0 .4-.1.1-.1.3-.3.4l-.2.3c-.1.1-.1.2 0 .4.1.1.5.9 1.1 1.4.8.7 1.4 1 1.6 1.1.2.1.3.1.5-.1.1-.1.5-.6.6-.8.2-.2.3-.2.5-.1.2.1 1.2.6 1.4.7.2.1.4.2.4.3.1.2.1.8-.1 1.3z"/>
                        </svg>
                    </a>
                    <a class="contacts-page__social" href="#" aria-label="Facebook">
                        <svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" d="M13.5 22v-8h2.6l.4-3h-3V9.1c0-.86.24-1.45 1.48-1.45H16.6V5a22.2 22.2 0 0 0-2.46-.13c-2.44 0-4.1 1.49-4.1 4.22V11H7.4v3h2.64v8h3.46z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="contacts-page__right">
                <div class="contacts-page__panel">
                    <h2 class="contacts-page__panel-title">Потрібна консультація?</h2>
                    <p class="contacts-page__panel-description">Залиште заявку і ми допоможемо з усім розібратись.</p>

                    <form class="contact-form contacts-page__form" action="" method="post">
                        <input type="hidden" name="service" value="Контакти: консультація">

                        <div class="contact-form__row">
                            <label class="contact-form__field">
                                <span class="screen-reader-text">Ваше імʼя</span>
                                <input type="text" name="name" placeholder="Ваше імʼя">
                            </label>

                            <label class="contact-form__field">
                                <span class="screen-reader-text">Номер телефону</span>
                                <input type="tel" name="phone" placeholder="Номер телефону" inputmode="tel" autocomplete="tel">
                            </label>
                        </div>

                        <label class="contact-form__field contact-form__field--wide">
                            <span class="screen-reader-text">Ваше запитання</span>
                            <input type="text" name="question" placeholder="Ваше запитання">
                        </label>

                        <label class="contact-form__consent">
                            <input class="contact-form__consent-input" type="checkbox" name="consent" checked>
                            <span class="contact-form__consent-box" aria-hidden="true"></span>
                            <span class="contact-form__consent-label">Я погоджуюсь з політикою конфіденційності</span>
                        </label>

                        <button class="contact-form__submit contact-form__submit--contacts" type="submit">
                            <span>Отримати консультацію</span>
                            <span class="contact-form__submit-icon contact-form__submit-icon--contacts" aria-hidden="true">
                                <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.857 4.163H12.489V11.795" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
