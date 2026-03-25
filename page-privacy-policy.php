<?php
/**
 * Static page template for /privacy-policy/.
 *
 * @package constalt
 */

declare(strict_types=1);

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--privacy-policy">
    <?php get_template_part('template-parts/sections/privacy', 'policy'); ?>
</main>
<?php get_template_part('template-parts/components/site', 'popup'); ?>
<?php
get_footer();
