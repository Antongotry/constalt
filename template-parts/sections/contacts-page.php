<?php
/**
 * Contacts page section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_contacts_page_content();
$socials = is_array($content['socials']) ? $content['socials'] : [];
?>
<section class="contacts-page" id="contacts">
    <div class="contacts-page__container">
        <div class="contacts-page__layout">
            <div class="contacts-page__left">
                <div class="contacts-page__marker" aria-label="<?php esc_attr_e('Розділ контакти', 'constalt'); ?>">
                    <span class="contacts-page__marker-dot" aria-hidden="true"></span>
                    <span class="contacts-page__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></span>
                </div>

                <h1 class="contacts-page__title"><?php echo esc_html((string) $content['title']); ?></h1>

                <div class="contacts-page__info-grid contacts-page__info-grid--top">
                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label"><?php echo esc_html((string) $content['phone_label']); ?></p>
                        <a class="contacts-page__info-value" href="<?php echo esc_url(constalt_normalize_phone_href((string) $content['phone_value'])); ?>">
                            <?php echo esc_html((string) $content['phone_value']); ?>
                        </a>
                    </div>
                </div>

                <div class="contacts-page__socials" aria-label="<?php esc_attr_e('Соціальні мережі', 'constalt'); ?>">
                    <?php foreach ($socials as $social) : ?>
                        <?php
                        $network = (string) ($social['network'] ?? 'telegram');
                        $label = (string) ($social['aria_label'] ?? ucfirst($network));
                        $custom_icon = constalt_resolve_media_url($social['custom_icon'] ?? '');
                        ?>
                        <a class="contacts-page__social" href="<?php echo esc_url((string) ($social['url'] ?? '#')); ?>" aria-label="<?php echo esc_attr($label); ?>">
                            <?php if ($network === 'custom' && $custom_icon !== '') : ?>
                                <img class="contacts-page__social-icon" src="<?php echo esc_url($custom_icon); ?>" alt="" loading="lazy" decoding="async">
                            <?php else : ?>
                                <?php echo constalt_get_social_icon_svg($network); ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="contacts-page__info-grid contacts-page__info-grid--bottom">
                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label"><?php echo esc_html((string) $content['address_label']); ?></p>
                        <p class="contacts-page__info-value contacts-page__info-value--small"><?php echo nl2br(esc_html((string) $content['address_text'])); ?></p>
                    </div>

                    <div class="contacts-page__info-item">
                        <p class="contacts-page__info-label"><?php echo esc_html((string) $content['hours_label']); ?></p>
                        <p class="contacts-page__info-value contacts-page__info-value--small"><?php echo nl2br(esc_html((string) $content['hours_text'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="contacts-page__right">
                <div class="contacts-page__panel">
                    <h2 class="contacts-page__panel-title"><?php echo esc_html((string) $content['panel_title']); ?></h2>
                    <p class="contacts-page__panel-description"><?php echo constalt_render_inline_markup((string) $content['panel_description']); ?></p>

                    <form class="contact-form contacts-page__form" action="" method="post">
                        <input type="hidden" name="service" value="<?php echo esc_attr((string) $content['form_service']); ?>">

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

                        <button class="contact-form__submit contact-form__submit--contacts" type="submit">
                            <span><?php echo esc_html((string) $content['submit_label']); ?></span>
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
