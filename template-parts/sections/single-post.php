<?php
/**
 * Single post section.
 *
 * @package constalt
 */

declare(strict_types=1);

$post_id = (int) get_the_ID();
$post_permalink = get_permalink($post_id) ?: home_url('/');
$post_title = get_the_title($post_id);

$get_post_categories = static function (int $post_id): array {
    $categories = get_the_terms($post_id, 'category');

    if (empty($categories) || is_wp_error($categories)) {
        return array();
    }

    return array_slice($categories, 0, 2);
};

$get_acf_field_value = static function (array $field_names, int $post_id) {
    if (! function_exists('get_field')) {
        return null;
    }

    foreach ($field_names as $field_name) {
        $value = get_field($field_name, $post_id);

        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }
    }

    return null;
};

$get_acf_image = static function (array $field_names, int $post_id) use ($get_acf_field_value): ?array {
    $raw_image = $get_acf_field_value($field_names, $post_id);

    if (empty($raw_image)) {
        return null;
    }

    if (is_numeric($raw_image)) {
        $image_id = (int) $raw_image;
        $image_src = wp_get_attachment_image_src($image_id, 'large');

        if (! empty($image_src[0])) {
            return array(
                'url' => (string) $image_src[0],
                'alt' => (string) get_post_meta($image_id, '_wp_attachment_image_alt', true),
            );
        }

        return null;
    }

    if (is_array($raw_image)) {
        $url = $raw_image['url'] ?? '';
        $alt = $raw_image['alt'] ?? '';

        if ($url !== '') {
            return array(
                'url' => (string) $url,
                'alt' => (string) $alt,
            );
        }

        $image_id = isset($raw_image['ID']) ? (int) $raw_image['ID'] : 0;

        if ($image_id > 0) {
            $image_src = wp_get_attachment_image_src($image_id, 'large');

            if (! empty($image_src[0])) {
                return array(
                    'url' => (string) $image_src[0],
                    'alt' => (string) get_post_meta($image_id, '_wp_attachment_image_alt', true),
                );
            }
        }

        return null;
    }

    if (is_string($raw_image)) {
        return array(
            'url' => $raw_image,
            'alt' => '',
        );
    }

    return null;
};

$additional_image_left = $get_acf_image(
    array('additional_image_left', 'additional_image_1', 'post_additional_image_1'),
    $post_id
);
$additional_image_right = $get_acf_image(
    array('additional_image_right', 'additional_image_2', 'post_additional_image_2'),
    $post_id
);

$additional_text = $get_acf_field_value(
    array('additional_text', 'post_additional_text', 'single_post_additional_text'),
    $post_id
);

if (! is_string($additional_text) || $additional_text === '') {
    $additional_text = has_excerpt($post_id) ? get_the_excerpt($post_id) : '';
}

$post_categories = $get_post_categories($post_id);
$encoded_url = rawurlencode($post_permalink);
$encoded_title = rawurlencode($post_title);

$telegram_share_link = 'https://t.me/share/url?url=' . $encoded_url . '&text=' . $encoded_title;
$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
$instagram_link = 'https://www.instagram.com/';

$blog_archive_link = home_url('/blog/');

$related_posts = get_posts(
    array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 3,
        'post__not_in'        => array($post_id),
        'ignore_sticky_posts' => true,
    )
);

$related_primary_post = $related_posts[0] ?? null;
$related_secondary_posts = array_slice($related_posts, 1, 2);
?>
<section class="single-article">
    <div class="single-article__container">
        <div class="single-article__marker">
            <span class="single-article__marker-dot" aria-hidden="true"></span>
            <p class="single-article__marker-text">Блог/Стаття</p>
        </div>

        <div class="single-article__layout">
            <aside class="single-article__share" aria-label="Поділитись статтею">
                <p class="single-article__share-label">Поділитись</p>
                <div class="single-article__share-list">
                    <a class="single-article__share-link site-footer__social" href="<?php echo esc_url($telegram_share_link); ?>" target="_blank" rel="noopener noreferrer" aria-label="Поділитися у Telegram">
                        <svg class="single-article__share-icon site-footer__social-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path fill="currentColor" d="M20.76 4.2 3.95 10.68c-1.15.47-1.14 1.11-.2 1.39l4.31 1.34 9.96-6.28c.47-.29.9-.13.55.18l-8.07 7.29-.3 4.53c.44 0 .64-.2.89-.44l2.15-2.09 4.47 3.3c.83.46 1.42.22 1.63-.77l2.86-13.48c.31-1.21-.47-1.76-1.34-1.37z"/>
                        </svg>
                    </a>
                    <a class="single-article__share-link site-footer__social" href="<?php echo esc_url($instagram_link); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <svg class="single-article__share-icon site-footer__social-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.86 1.43a1.34 1.34 0 1 1 0 2.68 1.34 1.34 0 0 1 0-2.68zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9A3.1 3.1 0 1 0 12 15.1 3.1 3.1 0 0 0 12 8.9z"/>
                        </svg>
                    </a>
                    <a class="single-article__share-link site-footer__social" href="<?php echo esc_url($facebook_share_link); ?>" target="_blank" rel="noopener noreferrer" aria-label="Поділитися у Facebook">
                        <svg class="single-article__share-icon site-footer__social-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path fill="currentColor" d="M13.5 22v-8h2.6l.4-3h-3V9.1c0-.86.24-1.45 1.48-1.45H16.6V5a22.2 22.2 0 0 0-2.46-.13c-2.44 0-4.1 1.49-4.1 4.22V11H7.4v3h2.64v8h3.46z"/>
                        </svg>
                    </a>
                </div>
            </aside>

            <article class="single-article__body">
                <h1 class="single-article__title"><?php echo esc_html($post_title); ?></h1>

                <div class="single-article__featured">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', array('class' => 'single-article__featured-image', 'loading' => 'eager', 'decoding' => 'async')); ?>
                    <?php else : ?>
                        <span class="single-article__featured-fallback" aria-hidden="true"></span>
                    <?php endif; ?>
                </div>

                <div class="single-article__content">
                    <?php the_content(); ?>
                </div>

                <?php if ($additional_image_left || $additional_image_right) : ?>
                    <div class="single-article__gallery">
                        <?php if ($additional_image_left) : ?>
                            <figure class="single-article__gallery-item">
                                <img
                                    class="single-article__gallery-image"
                                    src="<?php echo esc_url($additional_image_left['url']); ?>"
                                    alt="<?php echo esc_attr($additional_image_left['alt'] ?: $post_title); ?>"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </figure>
                        <?php endif; ?>

                        <?php if ($additional_image_right) : ?>
                            <figure class="single-article__gallery-item">
                                <img
                                    class="single-article__gallery-image"
                                    src="<?php echo esc_url($additional_image_right['url']); ?>"
                                    alt="<?php echo esc_attr($additional_image_right['alt'] ?: $post_title); ?>"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </figure>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($additional_text !== '') : ?>
                    <div class="single-article__extra-text">
                        <?php echo wp_kses_post(wpautop($additional_text)); ?>
                    </div>
                <?php endif; ?>
            </article>

            <aside class="single-article__meta-column" aria-label="Дані статті">
                <div class="single-article__meta">
                    <time class="single-article__date" datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>">
                        <?php echo esc_html(get_the_date('d.m.Y', $post_id)); ?>
                    </time>

                    <?php if ($post_categories) : ?>
                        <div class="single-article__categories">
                            <?php foreach ($post_categories as $category) : ?>
                                <a class="single-article__category" href="<?php echo esc_url(get_category_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="blog-section single-related" id="more-news">
    <div class="blog-section__container">
        <h2 class="single-related__title">Новини <strong>Audit-Consulting</strong></h2>

        <?php if ($related_primary_post) : ?>
            <?php
            $primary_permalink = get_permalink($related_primary_post);
            $primary_categories = $get_post_categories((int) $related_primary_post->ID);
            ?>
            <div class="blog-layout single-related__layout">
                <article class="blog-post blog-post--featured">
                    <div class="blog-post__content">
                        <time class="blog-post__date" datetime="<?php echo esc_attr(get_the_date('c', $related_primary_post)); ?>">
                            <?php echo esc_html(get_the_date('d.m.Y', $related_primary_post)); ?>
                        </time>

                        <h3 class="blog-post__title">
                            <a href="<?php echo esc_url($primary_permalink); ?>">
                                <?php echo esc_html(get_the_title($related_primary_post)); ?>
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
                        <?php if (has_post_thumbnail($related_primary_post)) : ?>
                            <?php echo get_the_post_thumbnail($related_primary_post, 'large', array('class' => 'blog-post__image', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                        <?php else : ?>
                            <span class="blog-post__image-fallback" aria-hidden="true"></span>
                        <?php endif; ?>
                    </a>
                </article>

                <div class="blog-layout__side">
                    <?php foreach ($related_secondary_posts as $secondary_post) : ?>
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

            <a class="blog-section__all-link" href="<?php echo esc_url($blog_archive_link); ?>">
                <span>Усі новини</span>
            </a>
        <?php endif; ?>
    </div>
</section>
