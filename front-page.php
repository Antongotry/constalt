<?php
/**
 * Front page template.
 *
 * @package constalt
 */

get_header();
?>
<main id="primary" class="site-main site-main--front-page">
    <?php get_template_part('template-parts/sections/front-page', 'hero'); ?>
    <?php get_template_part('template-parts/sections/front-page', 'insight'); ?>
</main>
<?php
get_footer();
