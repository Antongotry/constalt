<?php
/**
 * Front-page hero section.
 *
 * @package constalt
 */

declare(strict_types=1);
?>
<section
    class="hero hero--front-page"
    style="--hero-bg-image: url('<?php echo esc_url(constalt_uploads_url('2026/03/hero-desc_result-scaled.webp')); ?>');"
>
    <div class="hero__media" aria-hidden="true">
        <video
            class="hero__media-video"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            poster="<?php echo esc_url(constalt_uploads_url('2026/03/hero-desc_result-scaled.webp')); ?>"
            width="1440"
            height="900"
        >
            <source src="<?php echo esc_url('https://audit-consulting.org/wp-content/uploads/2026/03/kling_20260322_作品_shot_1_4s__206_0.mp4'); ?>" media="(max-width: 1024px)" type="video/mp4">
            <source src="<?php echo esc_url(constalt_uploads_url('2026/03/kling_20260318_%E4%BD%9C%E5%93%81_Scene_1__A_891_0.mp4')); ?>" type="video/mp4">
        </video>
    </div>

    <div class="hero__bottom">
        <div class="hero__bottom-line" aria-hidden="true"></div>
        <div class="hero__bottom-content">
            <div class="hero__left">
                <div class="hero__preview-target">
                    <span class="hero__preview-dot" aria-hidden="true"></span>
                    <span class="hero__preview-text">Архітектура безпеки та ефективного управління вашим капіталом</span>
                </div>
                <h1 class="hero__title">
                    <span class="hero__title-line hero__title-line--strong">Консалтинг</span>
                    <span class="hero__title-line hero__title-line--light">для стратегічних управлінських рішень</span>
                    <span class="hero__title-line hero__title-line--light">у бізнесі</span>
                </h1>
            </div>
            <div class="hero__right">
                <p class="hero__description">
                    Системний консалтинг у сферах фінансів, корпоративного врядування та юридичного захисту для стабільного масштабування.
                </p>
                <div class="hero__actions">
                    <a class="hero-pill hero-pill--light" href="#" data-site-popup-open data-popup-key="consultation-general">
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
