<?php
/**
 * Front-page trust timeline section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_trust_content();
$items = is_array($content['items']) ? $content['items'] : [];
$background_left = constalt_resolve_media_url($content['background_left']);
$background_right = constalt_resolve_media_url($content['background_right']);
?>
<section
    class="trust-section"
    data-trust-section
    style="--constalt-media-trust-fad: url('<?php echo esc_url($background_left); ?>'); --constalt-media-trust-photo: url('<?php echo esc_url($background_right); ?>');"
>
    <div class="trust-section__container">
        <div class="trust-section__top-line" aria-hidden="true"></div>

        <div class="trust-section__layout">
            <div class="trust-section__left">
                <div class="trust-section__marker">
                    <span class="trust-section__marker-dot" aria-hidden="true"></span>
                    <p class="trust-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
                </div>

                <h2 class="trust-section__title">
                    <?php echo constalt_render_inline_markup((string) $content['title']); ?>
                </h2>
            </div>

            <div class="trust-timeline" data-trust-timeline>
                <div class="trust-timeline__track" data-trust-track>
                    <div class="trust-timeline__fill" data-trust-fill></div>
                </div>

                <div class="trust-timeline__items">
                    <?php foreach ($items as $index => $item) : ?>
                        <?php
                        $is_active = $index === 0;
                        $active_icon = constalt_resolve_media_url($item['active_icon'] ?? '');
                        $inactive_icon = constalt_resolve_media_url($item['inactive_icon'] ?? '');
                        $initial_icon = $is_active ? $active_icon : $inactive_icon;
                        ?>
                        <article class="trust-item" data-trust-step>
                            <div class="trust-item__icon-box<?php echo $is_active ? ' is-active' : ''; ?>" data-trust-icon-box>
                                <img
                                    class="trust-item__icon"
                                    src="<?php echo esc_url($initial_icon); ?>"
                                    alt=""
                                    width="24" height="24"
                                    loading="lazy" decoding="async"
                                    data-trust-icon
                                    data-icon-active="<?php echo esc_url($active_icon); ?>"
                                    data-icon-inactive="<?php echo esc_url($inactive_icon); ?>"
                                >
                            </div>
                            <div class="trust-item__content">
                                <h3 class="trust-item__title"><?php echo esc_html((string) ($item['title'] ?? '')); ?></h3>
                                <p class="trust-item__text"><?php echo constalt_render_inline_markup((string) ($item['text'] ?? '')); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
