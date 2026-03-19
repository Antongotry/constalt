<?php
/**
 * Front-page hero section.
 *
 * @package constalt
 */

declare(strict_types=1);

$asset_buster = (string) time();
?>
<section
    class="hero hero--front-page"
    style="--hero-bg-image: url('https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/hero-desc_result-scaled.webp?v=<?php echo esc_attr($asset_buster); ?>');"
>
    <?php get_template_part('template-parts/layout/site', 'header'); ?>
</section>
