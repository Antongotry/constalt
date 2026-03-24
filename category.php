<?php
/**
 * Category archive template.
 *
 * @package constalt
 */

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--blog">
    <?php get_template_part('template-parts/sections/blog', 'archive'); ?>
</main>
<?php get_template_part('template-parts/components/site', 'popup'); ?>
<?php
get_footer();
