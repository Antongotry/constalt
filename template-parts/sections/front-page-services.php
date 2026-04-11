<?php
/**
 * Front-page services section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_services_content();
$items = is_array($content['items']) ? $content['items'] : [];
?>
<section class="services-section" id="services">
    <div class="services-section__container">
        <div class="services-section__marker">
            <span class="services-section__marker-dot" aria-hidden="true"></span>
            <p class="services-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
        </div>

        <h2 class="services-section__title">
            <?php echo constalt_render_inline_markup((string) $content['title']); ?>
        </h2>

        <div class="services-tabs" role="tablist" aria-label="Напрямки роботи">
            <?php foreach ($items as $index => $item) : ?>
                <?php
                $tab_id = 'service-tab-' . ($index + 1);
                $panel_id = 'service-panel-' . ($index + 1);
                $is_active = $index === 0;
                ?>
                <button
                    class="services-tabs__item<?php echo $is_active ? ' services-tabs__item--active' : ''; ?>"
                    type="button"
                    role="tab"
                    aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo esc_attr($panel_id); ?>"
                    id="<?php echo esc_attr($tab_id); ?>"
                    data-service-tab="<?php echo esc_attr((string) ($index + 1)); ?>"
                >
                    <?php echo nl2br(esc_html((string) ($item['tab_label'] ?? ''))); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="services-swiper services-swiper--stack">
            <div class="services-swiper__wrapper">
                <?php foreach ($items as $index => $item) : ?>
                    <?php
                    $tab_id = 'service-tab-' . ($index + 1);
                    $panel_id = 'service-panel-' . ($index + 1);
                    $is_active = $index === 0;
                    $theme = sanitize_html_class((string) ($item['theme'] ?? 'finance'));
                    $image = constalt_resolve_media_url($item['image'] ?? '');
                    $primary_button = is_array($item['primary_button'] ?? null) ? $item['primary_button'] : constalt_default_button('');
                    $secondary_button = is_array($item['secondary_button'] ?? null) ? $item['secondary_button'] : constalt_default_button('');
                    ?>
                    <div class="services-swiper__slide">
                        <div
                            class="service-detail service-detail--<?php echo esc_attr($theme); ?><?php echo $is_active ? ' is-active' : ''; ?>"
                            id="<?php echo esc_attr($panel_id); ?>"
                            role="tabpanel"
                            aria-labelledby="<?php echo esc_attr($tab_id); ?>"
                            data-service-panel="<?php echo esc_attr((string) ($index + 1)); ?>"
                            <?php if (! $is_active) : ?>hidden<?php endif; ?>
                        >
                            <div class="service-detail__media" aria-hidden="true">
                                <div
                                    class="service-detail__media-inner"
                                    <?php if ($image !== '') : ?>
                                        style="background-image: url('<?php echo esc_url($image); ?>');"
                                    <?php endif; ?>
                                ></div>
                            </div>

                            <div class="service-detail__content">
                                <div class="service-detail__top">
                                    <h3 class="service-detail__title">
                                        <?php echo constalt_render_inline_markup((string) ($item['title'] ?? '')); ?>
                                    </h3>

                                    <p class="service-detail__subtitle"><?php echo constalt_render_inline_markup((string) ($item['subtitle'] ?? '')); ?></p>

                                    <div class="service-detail__box service-detail__box--problem<?php echo ! empty($item['problem_tall']) ? ' service-detail__box--problem-tall' : ''; ?>">
                                        <p class="service-detail__box-label"><?php echo esc_html((string) ($item['problem_label'] ?? '')); ?></p>
                                        <p class="service-detail__box-text"><?php echo constalt_render_inline_markup((string) ($item['problem_text'] ?? '')); ?></p>
                                    </div>
                                </div>

                                <div class="service-detail__bottom">
                                    <p class="service-detail__label"><?php echo esc_html((string) ($item['doing_label'] ?? '')); ?></p>
                                    <p class="service-detail__doing"><?php echo constalt_render_inline_markup((string) ($item['doing_text'] ?? '')); ?></p>

                                    <div class="service-detail__box service-detail__box--result">
                                        <p class="service-detail__box-label"><?php echo esc_html((string) ($item['result_label'] ?? '')); ?></p>
                                        <p class="service-detail__box-text"><?php echo constalt_render_inline_markup((string) ($item['result_text'] ?? '')); ?></p>
                                    </div>

                                    <div class="service-detail__actions">
                                        <a
                                            class="hero-pill hero-pill--light service-detail__action"
                                            href="<?php echo esc_url((string) ($primary_button['url'] ?? '#')); ?>"
                                            <?php if (! empty($primary_button['popup_key'])) : ?>
                                                data-site-popup-open
                                                data-popup-key="<?php echo esc_attr((string) $primary_button['popup_key']); ?>"
                                            <?php endif; ?>
                                        >
                                            <span class="hero-pill__label"><?php echo esc_html((string) ($primary_button['label'] ?? '')); ?></span>
                                            <span class="hero-pill__icon" aria-hidden="true">
                                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.163 12.489L12.489 4.163" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M4.857 4.163H12.489V11.795" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </a>

                                        <a
                                            class="hero-pill hero-pill--outline-dark service-detail__action"
                                            href="<?php echo esc_url((string) ($secondary_button['url'] ?? '#')); ?>"
                                            <?php if (! empty($secondary_button['popup_key'])) : ?>
                                                data-site-popup-open
                                                data-popup-key="<?php echo esc_attr((string) $secondary_button['popup_key']); ?>"
                                            <?php endif; ?>
                                        >
                                            <span class="hero-pill__label"><?php echo esc_html((string) ($secondary_button['label'] ?? '')); ?></span>
                                            <span class="hero-pill__icon" aria-hidden="true">
                                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.163 12.489L12.489 4.163" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M4.857 4.163H12.489V11.795" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
