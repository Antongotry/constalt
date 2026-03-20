<?php
/**
 * Front-page contact section.
 *
 * @package constalt
 */
?>
<section class="contact-section" id="contact">
    <div class="contact-section__container">
        <div class="contact-panel">
            <div class="contact-panel__left">
                <h2 class="contact-panel__title">
                    У бізнесі важливо бачити<br><strong>повну картину</strong>
                </h2>

                <p class="contact-panel__description">
                    Якщо у вас є питання щодо фінансів, структури управління чи розвитку компанії —
                    <strong>обговоримо ситуацію та можливі рішення.</strong>
                </p>

                <form class="contact-form" action="#" method="post">
                    <div class="contact-form__row">
                        <label class="contact-form__field">
                            <span class="screen-reader-text">Ваше імʼя</span>
                            <input type="text" name="name" placeholder="Ваше імʼя">
                        </label>

                        <label class="contact-form__field">
                            <span class="screen-reader-text">Номер телефону</span>
                            <input type="tel" name="phone" placeholder="Номер телефону">
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

                    <button class="contact-form__submit" type="submit">
                        <span>Запланувати розмову</span>
                        <span class="contact-form__submit-icon" aria-hidden="true">
                            <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.857 4.163H12.489V11.795" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            <div class="contact-panel__media" aria-hidden="true">
                <div class="contact-panel__media-image"></div>
            </div>
        </div>
    </div>
</section>
