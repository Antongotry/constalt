<?php
/**
 * Front-page hero section.
 *
 * @package constalt
 */

declare(strict_types=1);

$asset_buster = (string) time();
?>
<section
    class="hero hero--front-page"
    style="--hero-bg-image: url('https://palevioletred-goat-904535.hostingersite.com/wp-content/uploads/2026/03/hero-desc_result-scaled.webp?v=<?php echo esc_attr($asset_buster); ?>');"
>
    <?php get_template_part('template-parts/layout/site', 'header'); ?>
    <div class="hero__bottom">
        <div class="hero__bottom-line" aria-hidden="true"></div>
        <div class="hero__bottom-content">
            <h1 class="hero__title">Консалтинг для управлінських рішень у бізнесі</h1>
            <div class="hero__right">
                <p class="hero__description">
                    Допомагаємо власникам систематизувати фінанси, знизити ризики та вибудувати структуру бізнесу, готову до масштабування або залучення інвестицій
                </p>
                <div class="hero__actions">
                    <a class="hero-pill hero-pill--light" href="#contact">
                        <span class="hero-pill__label">Отримати консультацію</span>
                        <span class="hero-pill__icon" aria-hidden="true">
                            <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.857 4.163H12.489V11.795" stroke="#051120" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                    <a class="hero-pill hero-pill--glass" href="#services">
                        <span class="hero-pill__label">Переглянути послуги</span>
                        <span class="hero-pill__icon" aria-hidden="true">
                            <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.163 12.489L12.489 4.163" stroke="#020D1C" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.857 4.163H12.489V11.795" stroke="#020D1C" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
