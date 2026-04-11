<?php
/**
 * Front-page hero section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_hero_content();

$desktop_poster = constalt_resolve_media_url($content['desktop_poster']);
$mobile_poster = constalt_resolve_media_url($content['mobile_poster'], $desktop_poster);
$desktop_video = constalt_resolve_media_url($content['desktop_video']);
$mobile_video = constalt_resolve_media_url($content['mobile_video']);
$primary_button = is_array($content['primary_button']) ? $content['primary_button'] : constalt_default_button('');
$secondary_button = is_array($content['secondary_button']) ? $content['secondary_button'] : constalt_default_button('');
?>
<section
    class="hero hero--front-page"
    style="--hero-bg-image: url('<?php echo esc_url($desktop_poster); ?>'); --constalt-media-hero-mobile: url('<?php echo esc_url($mobile_poster); ?>');"
>
    <?php if ($desktop_video !== '' || $mobile_video !== '') : ?>
        <div class="hero__media" aria-hidden="true">
            <video
                class="hero__media-video"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                poster="<?php echo esc_url($desktop_poster); ?>"
                width="1440"
                height="900"
            >
                <?php if ($mobile_video !== '') : ?>
                    <source src="<?php echo esc_url($mobile_video); ?>" media="(max-width: 1024px)" type="video/mp4">
                <?php endif; ?>
                <?php if ($desktop_video !== '') : ?>
                    <source src="<?php echo esc_url($desktop_video); ?>" type="video/mp4">
                <?php endif; ?>
            </video>
        </div>
    <?php endif; ?>

    <div class="hero__bottom">
        <div class="hero__bottom-line" aria-hidden="true"></div>
        <div class="hero__bottom-content">
            <div class="hero__left">
                <div class="hero__preview-target">
                    <span class="hero__preview-dot" aria-hidden="true"></span>
                    <span class="hero__preview-text"><?php echo constalt_render_inline_markup((string) $content['preview_text']); ?></span>
                </div>
                <h1 class="hero__title">
                    <?php echo constalt_render_title_lines((string) $content['title'], 'hero__title-line hero__title-line--light'); ?>
                </h1>
            </div>
            <div class="hero__right">
                <p class="hero__description">
                    <?php echo constalt_render_inline_markup((string) $content['description']); ?>
                </p>
                <div class="hero__actions">
                    <a
                        class="hero-pill hero-pill--light"
                        href="<?php echo esc_url((string) ($primary_button['url'] ?? '#')); ?>"
                        <?php if (! empty($primary_button['popup_key'])) : ?>
                            data-site-popup-open
                            data-popup-key="<?php echo esc_attr((string) $primary_button['popup_key']); ?>"
                        <?php endif; ?>
                    >
                        <span class="hero-pill__label"><?php echo esc_html((string) ($primary_button['label'] ?? '')); ?></span>
                        <span class="hero-pill__icon" aria-hidden="true">
                            <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.857 4.163H12.489V11.795" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                    <a
                        class="hero-pill hero-pill--glass"
                        href="<?php echo esc_url((string) ($secondary_button['url'] ?? '#')); ?>"
                        <?php if (! empty($secondary_button['popup_key'])) : ?>
                            data-site-popup-open
                            data-popup-key="<?php echo esc_attr((string) $secondary_button['popup_key']); ?>"
                        <?php endif; ?>
                    >
                        <span class="hero-pill__label"><?php echo esc_html((string) ($secondary_button['label'] ?? '')); ?></span>
                        <span class="hero-pill__icon" aria-hidden="true">
                            <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="#020D1C" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.857 4.163H12.489V11.795" stroke="#020D1C" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
