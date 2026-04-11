<?php
/**
 * Front-page insight section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_insight_content();
?>
<section class="insight-section">
    <div class="insight-section__line-top" aria-hidden="true"></div>

    <div class="insight-section__marker">
        <span class="insight-section__marker-dot" aria-hidden="true"></span>
        <p class="insight-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
    </div>

    <h2 class="insight-section__title">
        <?php echo constalt_render_inline_markup((string) $content['title']); ?>
    </h2>

    <div class="insight-section__line-vertical" aria-hidden="true"></div>

    <p class="insight-section__summary">
        <?php echo constalt_render_inline_markup((string) $content['summary']); ?>
    </p>

    <?php get_template_part('template-parts/sections/front-page-insight', 'maze'); ?>
</section>
