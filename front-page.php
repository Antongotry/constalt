<?php
/**
 * Front page template.
 *
 * @package constalt
 */

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--front-page">
    <?php get_template_part('template-parts/sections/front-page', 'hero'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'insight'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'services'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'collaboration'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'trust'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'about'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'expert'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'partners'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'contact'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'faq'); ?>
</main>
<?php
get_footer();
