<?php
/**
 * Front-page expert section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_expert_content();
$quote_icon = constalt_resolve_media_url($content['quote_icon']);
$photo = constalt_resolve_media_url($content['photo']);
$badge_icon = constalt_resolve_media_url($content['badge_icon']);
$details = is_array($content['details']) ? $content['details'] : [];
?>
<section class="expert-section">
    <div class="expert-section__container">
        <div class="expert-section__layout">
            <div class="expert-section__left">
                <div class="expert-section__quote">
                    <?php if ($quote_icon !== '') : ?>
                        <img
                            class="expert-section__quote-icon"
                            src="<?php echo esc_url($quote_icon); ?>"
                            alt=""
                            aria-hidden="true"
                            width="74" height="65"
                            loading="lazy"
                            decoding="async"
                        >
                    <?php endif; ?>
                    <h2 class="expert-section__quote-text">
                        <?php echo constalt_render_inline_markup((string) $content['quote_text']); ?>
                    </h2>
                </div>

                <p class="expert-section__intro">
                    <?php echo constalt_render_inline_markup((string) $content['intro_text']); ?>
                </p>

                <div class="expert-section__divider" aria-hidden="true"></div>

                <h3 class="expert-section__name"><?php echo esc_html((string) $content['name']); ?></h3>
                <p class="expert-section__role"><?php echo esc_html((string) $content['role']); ?></p>

                <div class="expert-section__details">
                    <ul class="expert-section__list">
                        <?php foreach ($details as $detail) : ?>
                            <li class="expert-section__item">
                                <?php echo constalt_render_inline_markup((string) ($detail['text'] ?? '')); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <a class="expert-section__link" href="<?php echo esc_url((string) $content['link_url']); ?>">
                    <span><?php echo esc_html((string) $content['link_label']); ?></span>
                    <span class="expert-section__link-arrow" aria-hidden="true">
                        <svg viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.5 13.5L13.5 4.5" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.25 4.5H13.5V12.75" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>

            <div class="expert-section__right">
                <div class="expert-section__photo-frame">
                    <div
                        class="expert-section__photo"
                        aria-hidden="true"
                        <?php if ($photo !== '') : ?>
                            style="--constalt-media-expert-photo: url('<?php echo esc_url($photo); ?>');"
                        <?php endif; ?>
                    ></div>
                </div>

                <article class="expert-stat-card" aria-label="<?php echo esc_attr((string) $content['stat_value'] . (string) $content['stat_suffix'] . ' ' . str_replace("\n", ' ', (string) $content['stat_label'])); ?>">
                    <div class="expert-stat-card__inner">
                        <p class="expert-stat-card__label"><?php echo nl2br(esc_html((string) $content['stat_label'])); ?></p>

                        <div class="expert-stat-card__value-wrap">
                            <span class="expert-stat-card__value"><?php echo esc_html((string) $content['stat_value']); ?></span>
                            <span class="expert-stat-card__plus"><?php echo esc_html((string) $content['stat_suffix']); ?></span>
                            <span class="expert-stat-card__years"><?php echo esc_html((string) $content['stat_years_label']); ?></span>
                        </div>
                    </div>

                    <div class="expert-stat-card__badge" aria-hidden="true">
                        <div class="expert-stat-card__badge-inner">
                            <?php if ($badge_icon !== '') : ?>
                                <img
                                    src="<?php echo esc_url($badge_icon); ?>"
                                    alt=""
                                    width="24" height="24"
                                    loading="lazy"
                                    decoding="async"
                                >
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
