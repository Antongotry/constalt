<?php
/**
 * Front-page about section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_about_content();
$desktop_image = constalt_resolve_media_url($content['card_desktop_image']);
$mobile_image = constalt_resolve_media_url($content['card_mobile_image'], $desktop_image);
?>
<section class="about-section" id="about">
    <div class="about-section__container">
        <div class="about-section__marker">
            <span class="about-section__marker-dot" aria-hidden="true"></span>
            <p class="about-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
        </div>

        <h2 class="about-section__title">
            <?php echo constalt_render_inline_markup((string) $content['title']); ?>
        </h2>

        <div class="about-stage">
            <article
                class="about-card about-card--left"
                style="--constalt-media-about-main: url('<?php echo esc_url($desktop_image); ?>'); --constalt-media-about-mobile: url('<?php echo esc_url($mobile_image); ?>');"
            >
                <div class="about-card__glass">
                    <p class="about-card__lead"><?php echo constalt_render_inline_markup((string) $content['lead_text']); ?></p>
                    <p class="about-card__sub"><?php echo constalt_render_inline_markup((string) $content['lead_subtext']); ?></p>
                </div>

                <div class="about-card__plain">
                    <p class="about-card__plain-title"><?php echo constalt_render_inline_markup((string) $content['plain_title']); ?></p>
                    <p class="about-card__plain-text"><?php echo constalt_render_inline_markup((string) $content['plain_text']); ?></p>
                </div>
            </article>

            <article class="about-card about-card--year">
                <div class="about-card__year-inner">
                    <div class="about-card__year-head">
                        <span class="about-card__year-pre"><?php echo esc_html((string) $content['year_prefix']); ?></span>
                        <span class="about-card__year-number"><?php echo esc_html((string) $content['year_number']); ?></span>
                        <span class="about-card__year-post"><?php echo esc_html((string) $content['year_suffix']); ?></span>
                    </div>

                    <p class="about-card__year-text"><?php echo constalt_render_inline_markup((string) $content['year_text']); ?></p>
                </div>
            </article>
        </div>
    </div>
</section>
