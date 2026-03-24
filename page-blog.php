<?php
/**
 * Static page template for /blog/ archive output.
 *
 * @package constalt
 */

declare(strict_types=1);

$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));

$blog_query = new WP_Query(
    array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => (int) get_option('posts_per_page'),
        'paged'               => $paged,
        'ignore_sticky_posts' => true,
    )
);

set_query_var('constalt_blog_query', $blog_query);

get_header();
?>
<?php get_template_part('template-parts/layout/site', 'header'); ?>
<main id="primary" class="site-main site-main--blog">
    <?php get_template_part('template-parts/sections/blog', 'archive'); ?>
</main>
<?php get_template_part('template-parts/components/site', 'popup'); ?>
<?php
wp_reset_postdata();
set_query_var('constalt_blog_query', null);
get_footer();
