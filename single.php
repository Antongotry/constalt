<?php
/**
 * Single post template.
 *
 * @package constalt
 */

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--single-post">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/sections/single', 'post'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_template_part('template-parts/components/site', 'popup'); ?>
<?php
get_footer();
