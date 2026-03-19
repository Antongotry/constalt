<?php
/**
 * Front-page services section.
 *
 * @package constalt
 */
?>
<section class="services-section">
    <div class="services-section__container">
        <div class="services-section__marker">
            <span class="services-section__marker-dot" aria-hidden="true"></span>
            <p class="services-section__marker-text">Напрямки роботи з бізнесом</p>
        </div>

        <h2 class="services-section__title">
            Ми працюємо з ключовими системами бізнесу,
            від яких <strong>залежать стабільність компанії сьогодні
            та її розвиток у майбутньому</strong>
        </h2>

        <div class="services-tabs" role="tablist" aria-label="Напрямки роботи">
            <button class="services-tabs__item services-tabs__item--active" type="button" role="tab" aria-selected="true" aria-controls="service-panel-1" id="service-tab-1" data-service-tab="1">Фінансовий консалтинг<br>та управління прибутковістю</button>
            <button class="services-tabs__item" type="button" role="tab" aria-selected="false" aria-controls="service-panel-2" id="service-tab-2" data-service-tab="2">Корпоративне управління</button>
            <button class="services-tabs__item" type="button" role="tab" aria-selected="false" aria-controls="service-panel-3" id="service-tab-3" data-service-tab="3">Due Diligence та<br>інвестиційний супровід</button>
            <button class="services-tabs__item" type="button" role="tab" aria-selected="false" aria-controls="service-panel-4" id="service-tab-4" data-service-tab="4">Юридична архітектура<br>та захист активів</button>
        </div>

        <div class="service-detail service-detail--finance is-active" id="service-panel-1" role="tabpanel" aria-labelledby="service-tab-1" data-service-panel="1">
            <div class="service-detail__media" aria-hidden="true">
                <div class="service-detail__media-inner"></div>
            </div>

            <div class="service-detail__content">
                <div class="service-detail__top">
                    <h3 class="service-detail__title">
                        <strong>Фінансовий консалтинг</strong><br>
                        та управління прибутковістю
                    </h3>

                    <p class="service-detail__subtitle">Для власників, які прагнуть повного контролю над фінансами компанії.</p>

                    <div class="service-detail__box service-detail__box--problem">
                        <p class="service-detail__box-label">Проблема</p>
                        <p class="service-detail__box-text">Відсутність повної картини, касові розриви та рішення, що приймаються інтуїтивно, а не на основі цифр.</p>
                    </div>
                </div>

                <div class="service-detail__bottom">
                    <p class="service-detail__label">Що ми робимо:</p>
                    <p class="service-detail__doing">Впроваджуємо систему <strong>управлінської звітності (P&amp;L, Cash Flow, Balance) та будуємо фінансові моделі для прогнозування.</strong></p>

                    <div class="service-detail__box service-detail__box--result">
                        <p class="service-detail__box-label">Результат</p>
                        <p class="service-detail__box-text">Ви бачите реальну прибутковість кожного напрямку та приймаєте впевнені рішення на основі точних даних.</p>
                    </div>

                    <div class="service-detail__actions">
                        <a class="hero-pill hero-pill--light service-detail__action" href="#contact">
                            <span class="hero-pill__label">Обговорити задачу</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>

                        <a class="hero-pill hero-pill--outline-dark service-detail__action" href="#details">
                            <span class="hero-pill__label">Детальніше</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="service-detail service-detail--corporate" id="service-panel-2" role="tabpanel" aria-labelledby="service-tab-2" data-service-panel="2" hidden>
            <div class="service-detail__media" aria-hidden="true">
                <div class="service-detail__media-inner"></div>
            </div>

            <div class="service-detail__content">
                <div class="service-detail__top">
                    <h3 class="service-detail__title"><strong>Корпоративне</strong> управління</h3>

                    <p class="service-detail__subtitle">Для тих, хто переріс ручний контроль і прагне побудувати автономну систему.</p>

                    <div class="service-detail__box service-detail__box--problem">
                        <p class="service-detail__box-label">Проблема</p>
                        <p class="service-detail__box-text">Всі ключові процеси замкнені на власнику, відповідальність команди розмита, а система не встигає за масштабом бізнесу.</p>
                    </div>
                </div>

                <div class="service-detail__bottom">
                    <p class="service-detail__label">Що ми робимо:</p>
                    <p class="service-detail__doing">Розподіляємо ролі між власником, партнерами та менеджментом, <strong>впроваджуємо чіткі правила прийняття рішень та систему контролю.</strong></p>

                    <div class="service-detail__box service-detail__box--result">
                        <p class="service-detail__box-label">Результат</p>
                        <p class="service-detail__box-text">Налагоджена структура, де кожен знає свою зону відповідальності, а бізнес працює стабільно без вашої постійної мікроучасті.</p>
                    </div>

                    <div class="service-detail__actions">
                        <a class="hero-pill hero-pill--light service-detail__action" href="#contact">
                            <span class="hero-pill__label">Обговорити задачу</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>

                        <a class="hero-pill hero-pill--outline-dark service-detail__action" href="#details">
                            <span class="hero-pill__label">Детальніше</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="service-detail service-detail--due-diligence" id="service-panel-3" role="tabpanel" aria-labelledby="service-tab-3" data-service-panel="3" hidden>
            <div class="service-detail__media" aria-hidden="true">
                <div class="service-detail__media-inner"></div>
            </div>

            <div class="service-detail__content">
                <div class="service-detail__top">
                    <h3 class="service-detail__title">Due Diligence та<br><strong>інвестиційний супровід</strong></h3>

                    <p class="service-detail__subtitle">Підготовка до залучення капіталу, продажу частки або входу в нове партнерство.</p>

                    <div class="service-detail__box service-detail__box--problem">
                        <p class="service-detail__box-label">Проблема</p>
                        <p class="service-detail__box-text">Ризики, які можуть проявитися після угоди, та слабка позиція в переговорах через недостатню підготовку.</p>
                    </div>
                </div>

                <div class="service-detail__bottom">
                    <p class="service-detail__label">Що ми робимо:</p>
                    <p class="service-detail__doing"><strong>Проводимо глибокий фінансовий та юридичний аналіз (Due Diligence),</strong> виявляємо «підводні камені» та готуємо компанію до перевірки інвестором.</p>

                    <div class="service-detail__box service-detail__box--result">
                        <p class="service-detail__box-label">Результат</p>
                        <p class="service-detail__box-text">Укладання угоди на вигідних умовах із повним розумінням реального стану справ та захищеною позицією.</p>
                    </div>

                    <div class="service-detail__actions">
                        <a class="hero-pill hero-pill--light service-detail__action" href="#contact">
                            <span class="hero-pill__label">Обговорити задачу</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>

                        <a class="hero-pill hero-pill--outline-dark service-detail__action" href="#details">
                            <span class="hero-pill__label">Детальніше</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="service-detail service-detail--legal" id="service-panel-4" role="tabpanel" aria-labelledby="service-tab-4" data-service-panel="4" hidden>
            <div class="service-detail__media" aria-hidden="true">
                <div class="service-detail__media-inner"></div>
            </div>

            <div class="service-detail__content">
                <div class="service-detail__top">
                    <h3 class="service-detail__title"><strong>Юридична архітектура</strong><br>та захист активів</h3>

                    <p class="service-detail__subtitle">Створення надійного фундаменту та оперативний захист інтересів власника.</p>

                    <div class="service-detail__box service-detail__box--problem service-detail__box--problem-tall">
                        <p class="service-detail__box-label">Проблема</p>
                        <p class="service-detail__box-text">Вразливість перед перевірками, рейдерськими атаками чи недобросовісними партнерами, а також ризики через помилки у документах минулих років.</p>
                    </div>
                </div>

                <div class="service-detail__bottom">
                    <p class="service-detail__label">Що ми робимо:</p>
                    <p class="service-detail__doing"><strong>Проводимо глибокий фінансовий та юридичний аналіз (Due Diligence),</strong> виявляємо «підводні камені» та готуємо компанію до перевірки інвестором.</p>

                    <div class="service-detail__box service-detail__box--result">
                        <p class="service-detail__box-label">Результат</p>
                        <p class="service-detail__box-text">Юридично захищена модель бізнесу, готова як до масштабування, так і до активного захисту прав у суді.</p>
                    </div>

                    <div class="service-detail__actions">
                        <a class="hero-pill hero-pill--light service-detail__action" href="#contact">
                            <span class="hero-pill__label">Обговорити задачу</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#192432" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>

                        <a class="hero-pill hero-pill--outline-dark service-detail__action" href="#details">
                            <span class="hero-pill__label">Детальніше</span>
                            <span class="hero-pill__icon" aria-hidden="true">
                                <svg viewBox="0 0 16.652 16.652" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.163 12.489L12.489 4.163" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.857 4.163H12.489V11.795" stroke="#FFF" stroke-width="1.176" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
