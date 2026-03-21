<?php
/**
 * Global site popup form.
 *
 * @package constalt
 */
?>
<div class="services-popup services-popup--service" data-services-popup hidden>
    <div class="services-popup__backdrop" data-services-popup-close></div>

    <div class="services-popup__dialog" role="dialog" aria-modal="true" aria-labelledby="services-popup-title">
        <button class="services-popup__close" type="button" aria-label="Закрити" data-services-popup-close>
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 11L37 37" stroke="#051120" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M37 11L11 37" stroke="#051120" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>

        <h3 class="services-popup__title" id="services-popup-title" data-services-popup-title>
            Due Diligence та<br><strong>інвестиційний супровід</strong>
        </h3>
        <p class="services-popup__subtitle" data-services-popup-subtitle>
            Підготовка до залучення капіталу, продажу частки або входу в нове партнерство.
        </p>

        <form class="services-popup__form" action="#" method="post">
            <input type="hidden" name="service" value="" data-services-popup-service>

            <div class="services-popup__row">
                <label class="services-popup__field">
                    <span class="screen-reader-text">Ваше імʼя</span>
                    <input type="text" name="name" placeholder="Ваше імʼя">
                </label>

                <label class="services-popup__field">
                    <span class="screen-reader-text">Номер телефону</span>
                    <input type="tel" name="phone" placeholder="Номер телефону">
                </label>
            </div>

            <label class="services-popup__field services-popup__field--wide" data-services-popup-wide-field>
                <span class="screen-reader-text" data-services-popup-wide-label-screen>Ваша проблема</span>
                <input type="text" name="question" placeholder="Ваша проблема" data-services-popup-wide-input>
            </label>

            <label class="services-popup__consent">
                <input class="services-popup__consent-input" type="checkbox" name="consent" checked>
                <span class="services-popup__consent-box" aria-hidden="true"></span>
                <span class="services-popup__consent-label">Я погоджуюсь з політикою конфіденційності</span>
            </label>

            <button class="services-popup__submit" type="submit">
                <span data-services-popup-submit-label>Обговорити задачу</span>
                <span class="services-popup__submit-icon" aria-hidden="true">
                    <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.163 12.489L12.489 4.163" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M4.857 4.163H12.489V11.795" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>
        </form>
    </div>
</div>

<div class="thanks-popup" data-thanks-popup hidden>
    <div class="thanks-popup__backdrop" data-thanks-popup-close></div>

    <div class="thanks-popup__dialog" role="dialog" aria-modal="true" aria-labelledby="thanks-popup-title">
        <button class="thanks-popup__close" type="button" aria-label="Закрити" data-thanks-popup-close>
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 11L37 37" stroke="#051120" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M37 11L11 37" stroke="#051120" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </button>

        <span class="thanks-popup__badge" aria-hidden="true"></span>

        <h3 class="thanks-popup__title" id="thanks-popup-title">
            <span>Дякуємо!</span> <strong>Вашу заявку отримано</strong>
        </h3>

        <p class="thanks-popup__text">
            Ми вже отримали ваші контактні дані. Наш менеджер зв'яжеться з вами найближчим часом, щоб відповісти на всі ваші запитання та узгодити деталі.
        </p>
    </div>
</div>
