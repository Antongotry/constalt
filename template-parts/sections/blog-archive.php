<?php
/**
 * Blog archive section.
 *
 * @package constalt
 */

declare(strict_types=1);

global $wp_query;

$custom_blog_query = get_query_var('constalt_blog_query');
$blog_query = $custom_blog_query instanceof WP_Query ? $custom_blog_query : $wp_query;

$posts = array();

if ($blog_query instanceof WP_Query && !empty($blog_query->posts)) {
    $posts = $blog_query->posts;
}

$featured_post = $posts[0] ?? null;
$secondary_posts = array_slice($posts, 1);

$blog_archive_link = home_url('/blog/');

$active_category_slug = '';

if (is_category()) {
    $queried_object = get_queried_object();

    if ($queried_object instanceof WP_Term) {
        $active_category_slug = (string) $queried_object->slug;
    }
}

$categories = get_categories(
    array(
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    )
);

$get_post_categories = static function (int $post_id): array {
    $post_categories = get_the_terms($post_id, 'category');

    if (empty($post_categories) || is_wp_error($post_categories)) {
        return array();
    }

    return array_slice($post_categories, 0, 2);
};

$get_post_category_slugs = static function (int $post_id): array {
    $post_categories = get_the_terms($post_id, 'category');

    if (empty($post_categories) || is_wp_error($post_categories)) {
        return array();
    }

    return array_values(
        array_filter(
            array_map(
                static fn ($category): string => $category instanceof WP_Term ? (string) $category->slug : '',
                $post_categories
            )
        )
    );
};

$current_page = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$total_pages = max(1, (int) ($blog_query instanceof WP_Query ? $blog_query->max_num_pages : 1));
$pagination_base = str_replace('999999999', '%#%', esc_url(get_pagenum_link(999999999)));
?>
<section class="blog-section blog-section--archive" id="news">
    <div class="blog-section__container">
        <div class="blog-section__head blog-section__head--archive">
            <div class="blog-section__marker">
                <span class="blog-section__marker-dot" aria-hidden="true"></span>
                <p class="blog-section__marker-text">Блог</p>
            </div>

            <h1 class="blog-section__title">Експертиза і новини</h1>
        </div>

        <div class="blog-page__filters" aria-label="Рубрики блогу">
            <a
                class="blog-page__filter<?php echo $active_category_slug === '' ? ' is-active' : ''; ?>"
                href="<?php echo esc_url($blog_archive_link); ?>"
                data-blog-filter=""
            >
                Усі рубрики
            </a>

            <?php foreach ($categories as $category) : ?>
                <?php
                $category_link = get_category_link($category);
                $is_active_category = $active_category_slug === (string) $category->slug;
                ?>
                <a
                    class="blog-page__filter<?php echo $is_active_category ? ' is-active' : ''; ?>"
                    href="<?php echo esc_url($category_link); ?>"
                    data-blog-filter="<?php echo esc_attr((string) $category->slug); ?>"
                >
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($featured_post) : ?>
            <?php
            $featured_permalink = get_permalink($featured_post);
            $featured_categories = $get_post_categories((int) $featured_post->ID);
            $featured_category_slugs = $get_post_category_slugs((int) $featured_post->ID);
            ?>
            <div class="blog-layout blog-layout--archive">
                <article
                    class="blog-post blog-post--featured"
                    data-blog-post
                    data-blog-categories="<?php echo esc_attr(implode(' ', $featured_category_slugs)); ?>"
                >
                    <div class="blog-post__content">
                        <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c', $featured_post)); ?>">
                            <?php echo esc_html(get_the_date('d.m.Y', $featured_post)); ?>
                        </time>

                        <h2 class="blog-post__title">
                            <a href="<?php echo esc_url($featured_permalink); ?>">
                                <?php echo esc_html(get_the_title($featured_post)); ?>
                            </a>
                        </h2>

                        <?php if ($featured_categories) : ?>
                            <div class="blog-post__categories">
                                <?php foreach ($featured_categories as $category) : ?>
                                    <a class="blog-post__category" href="<?php echo esc_url(get_category_link($category)); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a class="blog-post__media blog-post__media--featured" href="<?php echo esc_url($featured_permalink); ?>">
                        <?php if (has_post_thumbnail($featured_post)) : ?>
                            <?php echo get_the_post_thumbnail($featured_post, 'large', array('class' => 'blog-post__image', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                        <?php else : ?>
                            <span class="blog-post__image-fallback" aria-hidden="true"></span>
                        <?php endif; ?>
                    </a>
                </article>

                <div class="blog-layout__side">
                    <?php foreach ($secondary_posts as $secondary_post) : ?>
                        <?php
                        $secondary_permalink = get_permalink($secondary_post);
                        $secondary_categories = $get_post_categories((int) $secondary_post->ID);
                        $secondary_category_slugs = $get_post_category_slugs((int) $secondary_post->ID);
                        ?>
                        <article
                            class="blog-post blog-post--compact"
                            data-blog-post
                            data-blog-categories="<?php echo esc_attr(implode(' ', $secondary_category_slugs)); ?>"
                        >
                            <div class="blog-post__content">
                                <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c', $secondary_post)); ?>">
                                    <?php echo esc_html(get_the_date('d.m.Y', $secondary_post)); ?>
                                </time>

                                <h2 class="blog-post__title">
                                    <a href="<?php echo esc_url($secondary_permalink); ?>">
                                        <?php echo esc_html(get_the_title($secondary_post)); ?>
                                    </a>
                                </h2>

                                <?php if ($secondary_categories) : ?>
                                    <div class="blog-post__categories">
                                        <?php foreach ($secondary_categories as $category) : ?>
                                            <a class="blog-post__category" href="<?php echo esc_url(get_category_link($category)); ?>">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a class="blog-post__media blog-post__media--compact" href="<?php echo esc_url($secondary_permalink); ?>">
                                <?php if (has_post_thumbnail($secondary_post)) : ?>
                                    <?php echo get_the_post_thumbnail($secondary_post, 'medium_large', array('class' => 'blog-post__image', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                                <?php else : ?>
                                    <span class="blog-post__image-fallback" aria-hidden="true"></span>
                                <?php endif; ?>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($total_pages > 1) : ?>
                <nav class="blog-page__pagination" aria-label="Пагінація блогу">
                    <?php
                    echo wp_kses_post(
                        paginate_links(
                            array(
                                'type'      => 'list',
                                'base'      => $pagination_base,
                                'current'   => $current_page,
                                'total'     => $total_pages,
                                'mid_size'  => 1,
                                'prev_text' => '&larr;',
                                'next_text' => '&rarr;',
                            )
                        )
                    );
                    ?>
                </nav>
            <?php endif; ?>
        <?php else : ?>
            <p class="blog-section__empty">Додайте записи блогу, щоб показати цей блок.</p>
        <?php endif; ?>
    </div>
</section>
