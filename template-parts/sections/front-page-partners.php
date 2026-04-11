<?php
/**
 * Front-page partners section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_partners_content();
$items = is_array($content['items']) ? $content['items'] : [];
?>
<section class="partners-section">
    <div class="partners-section__container">
        <div class="partners-section__marker">
            <span class="partners-section__marker-dot" aria-hidden="true"></span>
            <p class="partners-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
        </div>

        <div class="partners-grid">
            <?php foreach ($items as $item) : ?>
                <?php
                $logo = constalt_resolve_media_url($item['logo'] ?? '');
                $modifier = sanitize_html_class((string) ($item['modifier'] ?? 'default'));
                $modifier_class = $modifier !== 'default' && $modifier !== '' ? ' partners-card__logo--' . $modifier : '';
                ?>
                <article class="partners-card">
                    <?php if ($logo !== '') : ?>
                        <img
                            class="partners-card__logo<?php echo esc_attr($modifier_class); ?>"
                            src="<?php echo esc_url($logo); ?>"
                            alt="<?php echo esc_attr((string) ($item['alt'] ?? '')); ?>"
                            loading="lazy"
                            decoding="async"
                        >
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
