<?php
/**
 * Front-page blog section.
 *
 * @package constalt
 */

$blog_posts = get_posts(
    array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
    )
);

$primary_post = $blog_posts[0] ?? null;
$secondary_posts = array_slice($blog_posts, 1, 2);

$get_post_categories = static function (int $post_id): array {
    $categories = get_the_terms($post_id, 'category');

    if (empty($categories) || is_wp_error($categories)) {
        return array();
    }

    return array_slice($categories, 0, 2);
};
?>
<section class="blog-section" id="news">
    <div class="blog-section__container">
        <div class="blog-section__head">
            <div class="blog-section__marker">
                <span class="blog-section__marker-dot" aria-hidden="true"></span>
                <p class="blog-section__marker-text">Блог</p>
            </div>

            <h2 class="blog-section__title">Новини <strong>Audit-Consulting</strong></h2>
        </div>

        <?php if ($primary_post) : ?>
            <?php
            $primary_permalink = get_permalink($primary_post);
            $primary_categories = $get_post_categories((int) $primary_post->ID);
            ?>
            <div class="blog-layout">
                <article class="blog-post blog-post--featured">
                    <div class="blog-post__content">
                        <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c', $primary_post)); ?>">
                            <?php echo esc_html(get_the_date('d.m.Y', $primary_post)); ?>
                        </time>

                        <h3 class="blog-post__title">
                            <a href="<?php echo esc_url($primary_permalink); ?>">
                                <?php echo esc_html(get_the_title($primary_post)); ?>
                            </a>
                        </h3>

                        <?php if ($primary_categories) : ?>
                            <div class="blog-post__categories">
                                <?php foreach ($primary_categories as $category) : ?>
                                    <a class="blog-post__category" href="<?php echo esc_url(get_category_link($category)); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a class="blog-post__media blog-post__media--featured" href="<?php echo esc_url($primary_permalink); ?>">
                        <?php if (has_post_thumbnail($primary_post)) : ?>
                            <?php echo get_the_post_thumbnail($primary_post, 'large', array('class' => 'blog-post__image', 'loading' => 'lazy', 'decoding' => 'async')); ?>
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
                        ?>
                        <article class="blog-post blog-post--compact">
                            <div class="blog-post__content">
                                <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c', $secondary_post)); ?>">
                                    <?php echo esc_html(get_the_date('d.m.Y', $secondary_post)); ?>
                                </time>

                                <h3 class="blog-post__title">
                                    <a href="<?php echo esc_url($secondary_permalink); ?>">
                                        <?php echo esc_html(get_the_title($secondary_post)); ?>
                                    </a>
                                </h3>

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
        <?php else : ?>
            <p class="blog-section__empty">Додайте записи блогу, щоб показати цей блок.</p>
        <?php endif; ?>
    </div>
</section>
