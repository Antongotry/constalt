<?php
/**
 * Front-page collaboration section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_collaboration_content();
$cards = is_array($content['cards']) ? $content['cards'] : [];
$style_classes = [
    'expert' => 'collaboration-card--dark collaboration-card--expert',
    'project' => 'collaboration-card--light collaboration-card--project',
    'strategic' => 'collaboration-card--gradient collaboration-card--strategic',
];
?>
<section class="collaboration-section">
    <div class="collaboration-section__container">
        <div class="collaboration-section__marker">
            <span class="collaboration-section__marker-dot" aria-hidden="true"></span>
            <p class="collaboration-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
        </div>

        <h2 class="collaboration-section__title">
            <?php echo constalt_render_inline_markup((string) $content['title']); ?>
        </h2>

        <div class="collaboration-cards">
            <?php foreach ($cards as $card) : ?>
                <?php
                $style = (string) ($card['style'] ?? 'expert');
                $card_class = $style_classes[$style] ?? $style_classes['expert'];
                $icon = constalt_resolve_media_url($card['icon'] ?? '');
                $button = is_array($card['button'] ?? null) ? $card['button'] : constalt_default_button('');
                $format_items = constalt_lines_to_array((string) ($card['format_items'] ?? ''));
                ?>
                <article class="collaboration-card <?php echo esc_attr($card_class); ?>">
                    <div class="collaboration-card__badge collaboration-card__badge--<?php echo $style === 'expert' ? 'light' : 'dark'; ?>" aria-hidden="true">
                        <span class="collaboration-card__badge-icon">
                            <?php if ($icon !== '') : ?>
                                <img src="<?php echo esc_url($icon); ?>" alt="" width="24" height="24" loading="lazy" decoding="async">
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="collaboration-card__content">
                        <h3 class="collaboration-card__title"><?php echo esc_html((string) ($card['title'] ?? '')); ?></h3>
                        <p class="collaboration-card__subtitle"><?php echo constalt_render_inline_markup((string) ($card['subtitle'] ?? '')); ?></p>

                        <div class="collaboration-card__line" aria-hidden="true"></div>

                        <p class="collaboration-card__format-label"><?php echo esc_html((string) ($card['format_label'] ?? '')); ?></p>
                        <ul class="collaboration-card__list">
                            <?php foreach ($format_items as $format_item) : ?>
                                <li><?php echo esc_html($format_item); ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="collaboration-card__result">
                            <p class="collaboration-card__result-label"><?php echo esc_html((string) ($card['result_label'] ?? '')); ?></p>
                            <p class="collaboration-card__result-text"><?php echo constalt_render_inline_markup((string) ($card['result_text'] ?? '')); ?></p>
                        </div>

                        <a
                            class="collaboration-card__link"
                            href="<?php echo esc_url((string) ($button['url'] ?? '#')); ?>"
                            <?php if (! empty($button['popup_key'])) : ?>
                                data-site-popup-open
                                data-popup-key="<?php echo esc_attr((string) $button['popup_key']); ?>"
                            <?php endif; ?>
                        >
                            <span><?php echo esc_html((string) ($button['label'] ?? '')); ?></span>
                            <span class="collaboration-card__link-arrow" aria-hidden="true">
                                <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.5 13.5L13.5 4.5" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5.25 4.5H13.5V12.75" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                        <div class="collaboration-card__link-line" aria-hidden="true"></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
