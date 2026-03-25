<?php
/**
 * Static page template for /contacts/.
 *
 * @package constalt
 */

declare(strict_types=1);

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--contacts">
    <?php get_template_part('template-parts/sections/contacts', 'page'); ?>
</main>
<?php get_template_part('template-parts/components/site', 'popup'); ?>
<?php
get_footer();
