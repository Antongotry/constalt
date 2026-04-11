<?php
/**
 * Front-page contact section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_contact_content();
$background_image = constalt_resolve_media_url($content['background_image']);
?>
<section class="contact-section" id="contact">
    <div class="contact-section__container">
        <div class="contact-panel">
            <div class="contact-panel__key-badge" aria-hidden="true">
                <img
                    src="<?php echo esc_url(constalt_uploads_url('2026/03/Key_fill.svg')); ?>"
                    alt=""
                    width="28" height="28"
                    loading="lazy"
                    decoding="async"
                >
            </div>

            <div class="contact-panel__left">
                <h2 class="contact-panel__title">
                    <?php echo constalt_render_inline_markup((string) $content['title']); ?>
                </h2>

                <p class="contact-panel__description">
                    <?php echo constalt_render_inline_markup((string) $content['description']); ?>
                </p>

                <form class="contact-form" action="" method="post">
                    <div class="contact-form__row">
                        <label class="contact-form__field">
                            <span class="screen-reader-text"><?php echo esc_html((string) $content['name_placeholder']); ?></span>
                            <input type="text" name="name" placeholder="<?php echo esc_attr((string) $content['name_placeholder']); ?>">
                        </label>

                        <label class="contact-form__field">
                            <span class="screen-reader-text"><?php echo esc_html((string) $content['phone_placeholder']); ?></span>
                            <input type="tel" name="phone" placeholder="<?php echo esc_attr((string) $content['phone_placeholder']); ?>" inputmode="tel" autocomplete="tel">
                        </label>
                    </div>

                    <label class="contact-form__field contact-form__field--wide">
                        <span class="screen-reader-text"><?php echo esc_html((string) $content['question_placeholder']); ?></span>
                        <input type="text" name="question" placeholder="<?php echo esc_attr((string) $content['question_placeholder']); ?>">
                    </label>

                    <label class="contact-form__consent">
                        <input class="contact-form__consent-input" type="checkbox" name="consent" checked>
                        <span class="contact-form__consent-box" aria-hidden="true"></span>
                        <span class="contact-form__consent-label"><?php echo esc_html((string) $content['consent_label']); ?></span>
                    </label>

                    <button class="contact-form__submit" type="submit">
                        <span><?php echo esc_html((string) $content['submit_label']); ?></span>
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
                <div
                    class="contact-panel__media-image"
                    <?php if ($background_image !== '') : ?>
                        style="background-image: url('<?php echo esc_url($background_image); ?>');"
                    <?php endif; ?>
                ></div>
            </div>
        </div>
    </div>
</section>
