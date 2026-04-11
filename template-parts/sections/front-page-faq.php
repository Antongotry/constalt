<?php
/**
 * Front-page FAQ section.
 *
 * @package constalt
 */

declare(strict_types=1);

$content = constalt_get_home_faq_content();
$items = is_array($content['items']) ? $content['items'] : [];
$cta_button = is_array($content['cta_button'] ?? null) ? $content['cta_button'] : constalt_default_button('');
?>
<section class="faq-section" id="faq">
    <div class="faq-section__container">
        <div class="faq-section__marker">
            <span class="faq-section__marker-dot" aria-hidden="true"></span>
            <p class="faq-section__marker-text"><?php echo constalt_render_inline_markup((string) $content['marker_text']); ?></p>
        </div>

        <h2 class="faq-section__title">
            <?php echo constalt_render_inline_markup((string) $content['title']); ?>
        </h2>

        <div class="faq-grid" data-faq-grid>
            <?php foreach ($items as $index => $item) : ?>
                <?php
                $faq_number = $index + 1;
                $trigger_id = 'faq-trigger-' . $faq_number;
                $answer_id = 'faq-answer-' . $faq_number;
                ?>
                <article class="faq-item" data-faq-item>
                    <button class="faq-item__trigger" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr($answer_id); ?>" id="<?php echo esc_attr($trigger_id); ?>" data-faq-trigger>
                        <span class="faq-item__text"><?php echo esc_html((string) ($item['question'] ?? '')); ?></span>
                        <span class="faq-item__chevron" aria-hidden="true"></span>
                    </button>
                    <div class="faq-item__content" id="<?php echo esc_attr($answer_id); ?>" role="region" aria-labelledby="<?php echo esc_attr($trigger_id); ?>" aria-hidden="true" data-faq-content>
                        <div class="faq-item__content-inner">
                            <?php echo constalt_render_inline_markup((string) ($item['answer'] ?? '')); ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="faq-cta">
            <div class="faq-cta__inner">
                <div class="faq-cta__content">
                    <div class="faq-cta__copy">
                        <h3 class="faq-cta__title"><?php echo esc_html((string) $content['cta_title']); ?></h3>
                        <p class="faq-cta__text"><?php echo constalt_render_inline_markup((string) $content['cta_text']); ?></p>
                    </div>

                    <a
                        class="faq-cta__button"
                        href="<?php echo esc_url((string) ($cta_button['url'] ?? '#')); ?>"
                        <?php if (! empty($cta_button['popup_key'])) : ?>
                            data-site-popup-open
                            data-popup-key="<?php echo esc_attr((string) $cta_button['popup_key']); ?>"
                        <?php endif; ?>
                    >
                        <span><?php echo esc_html((string) ($cta_button['label'] ?? '')); ?></span>
                        <span class="faq-cta__button-icon" aria-hidden="true">
                            <svg viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.857 4.163H12.489V11.795" stroke="currentColor" stroke-width="0.7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
