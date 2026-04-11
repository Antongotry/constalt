<?php
/**
 * Front-page insight maze scene.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_insight_content();
$maze_image = constalt_resolve_media_url($content['maze_image']);
$cards = is_array($content['cards']) ? $content['cards'] : [];
$width_classes = [
    'top-left' => 'insight-card__text--342',
    'top-right' => 'insight-card__text--381',
    'bottom-left' => 'insight-card__text--349',
    'bottom-right' => 'insight-card__text--383',
];
?>
<div class="insight-maze">
    <div
        class="insight-maze__image"
        aria-hidden="true"
        <?php if ($maze_image !== '') : ?>
            style="background-image: url('<?php echo esc_url($maze_image); ?>');"
        <?php endif; ?>
    ></div>

    <?php foreach ($cards as $card) : ?>
        <?php
        $position = isset($card['position']) ? (string) $card['position'] : 'top-left';
        $icon = constalt_resolve_media_url($card['icon'] ?? '');
        $width_class = $width_classes[$position] ?? 'insight-card__text--342';
        ?>
        <article class="insight-card insight-card--<?php echo esc_attr($position); ?>">
            <div class="insight-card__inner">
                <div class="insight-card__icon" aria-hidden="true">
                    <?php if ($icon !== '') : ?>
                        <img src="<?php echo esc_url($icon); ?>" alt="" width="32" height="32" loading="lazy" decoding="async">
                    <?php endif; ?>
                </div>
                <p class="insight-card__text <?php echo esc_attr($width_class); ?>">
                    <?php echo constalt_render_inline_markup((string) ($card['text'] ?? '')); ?>
                </p>
            </div>
        </article>
    <?php endforeach; ?>
</div>
