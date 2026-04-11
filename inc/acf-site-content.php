<?php
/**
 * ACF-powered site content settings for homepage and contacts page.
 *
 * @package constalt
 */

declare(strict_types=1);

/**
 * Returns whether ACF field access is available.
 */
function constalt_has_acf_fields(): bool
{
    return function_exists('get_field');
}

/**
 * Allowed inline tags for editable content blocks.
 *
 * Limits output to safe inline formatting that fits existing markup.
 *
 * @return array<string, array<string, bool>>
 */
function constalt_inline_allowed_tags(): array
{
    static $tags = null;

    if ($tags !== null) {
        return $tags;
    }

    $tags = [
        'br' => [],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        'span' => [
            'class' => true,
        ],
    ];

    return $tags;
}

/**
 * Sanitizes inline editable content.
 */
function constalt_render_inline_markup(string $value): string
{
    return wp_kses($value, constalt_inline_allowed_tags());
}

/**
 * Renders multiline content as individual span lines.
 */
function constalt_render_title_lines(string $value, string $line_class): string
{
    $value = trim($value);

    if ($value === '') {
        return '';
    }

    $lines = preg_split('/\R/u', $value) ?: [];
    $lines = array_values(
        array_filter(
            array_map('trim', $lines),
            static fn (string $line): bool => $line !== ''
        )
    );

    if ($lines === []) {
        $lines = [$value];
    }

    $markup = '';

    foreach ($lines as $line) {
        $markup .= sprintf(
            '<span class="%1$s">%2$s</span>',
            esc_attr($line_class),
            constalt_render_inline_markup($line)
        );
    }

    return $markup;
}

/**
 * Splits textarea content into plain list items.
 *
 * @return string[]
 */
function constalt_lines_to_array(string $value): array
{
    $lines = preg_split('/\R/u', trim($value)) ?: [];

    return array_values(
        array_filter(
            array_map('trim', $lines),
            static fn (string $line): bool => $line !== ''
        )
    );
}

/**
 * Compatibility helper for PHP versions without array_is_list().
 */
function constalt_is_list_array(array $value): bool
{
    $index = 0;

    foreach (array_keys($value) as $key) {
        if ($key !== $index) {
            return false;
        }

        ++$index;
    }

    return true;
}

/**
 * Deep-merges saved ACF values into default section data.
 *
 * @param mixed $defaults
 * @param mixed $value
 * @return mixed
 */
function constalt_merge_content_defaults($defaults, $value)
{
    if (! is_array($defaults)) {
        return ($value === null || $value === false) ? $defaults : $value;
    }

    if (! is_array($value)) {
        return $defaults;
    }

    if (constalt_is_list_array($defaults)) {
        return $value;
    }

    $result = $defaults;

    foreach ($value as $key => $item) {
        if (array_key_exists($key, $defaults)) {
            $result[$key] = constalt_merge_content_defaults($defaults[$key], $item);
            continue;
        }

        $result[$key] = $item;
    }

    return $result;
}

/**
 * Returns a grouped ACF option value with defaults.
 */
function constalt_get_option_group(string $field_name, array $defaults): array
{
    if (! constalt_has_acf_fields()) {
        return $defaults;
    }

    $value = get_field($field_name, 'option');

    if (! is_array($value)) {
        return $defaults;
    }

    return constalt_merge_content_defaults($defaults, $value);
}

/**
 * Resolves an ACF image/file value into a URL string.
 *
 * @param mixed $value
 */
function constalt_resolve_media_url($value, string $default = ''): string
{
    if (is_array($value)) {
        if (isset($value['url']) && is_string($value['url']) && $value['url'] !== '') {
            return $value['url'];
        }

        if (isset($value['ID']) && is_numeric($value['ID'])) {
            $url = wp_get_attachment_url((int) $value['ID']);

            if (is_string($url) && $url !== '') {
                return $url;
            }
        }

        if (isset($value['id']) && is_numeric($value['id'])) {
            $url = wp_get_attachment_url((int) $value['id']);

            if (is_string($url) && $url !== '') {
                return $url;
            }
        }
    }

    if (is_numeric($value)) {
        $url = wp_get_attachment_url((int) $value);

        if (is_string($url) && $url !== '') {
            return $url;
        }
    }

    if (is_string($value)) {
        $value = trim($value);

        if ($value === '') {
            return $default;
        }

        if (preg_match('#^(https?:)?//#i', $value) === 1 || str_starts_with($value, 'data:')) {
            return $value;
        }

        return constalt_uploads_url($value);
    }

    return $default;
}

/**
 * Creates a tel: href from a human-readable phone number.
 */
function constalt_normalize_phone_href(string $phone): string
{
    $digits = preg_replace('/\D+/', '', $phone);

    return $digits ? 'tel:+' . $digits : '#';
}

/**
 * Default button data.
 *
 * @return array{label:string,url:string,popup_key:string}
 */
function constalt_default_button(string $label, string $url = '#', string $popup_key = ''): array
{
    return [
        'label' => $label,
        'url' => $url,
        'popup_key' => $popup_key,
    ];
}

/**
 * Default content for the homepage hero.
 *
 * @return array<string, mixed>
 */
function constalt_home_hero_defaults(): array
{
    return [
        'preview_text' => 'Архітектура безпеки та ефективного управління вашим капіталом',
        'title' => "<strong>Консалтинг</strong> для стратегічних\nуправлінських рішень\nу бізнесі",
        'description' => 'Системний консалтинг у сферах фінансів, корпоративного врядування та юридичного захисту для стабільного масштабування.',
        'desktop_poster' => '2026/03/hero-desc_result-scaled.webp',
        'mobile_poster' => '2026/03/Frame-2087325716_result.webp',
        'desktop_video' => '2026/03/kling_20260318_%E4%BD%9C%E5%93%81_Scene_1__A_891_0.mp4',
        'mobile_video' => 'https://audit-consulting.org/wp-content/uploads/2026/03/kling_20260322_%E4%BD%9C%E5%93%81_shot_1_4s__206_0.mp4',
        'primary_button' => constalt_default_button('Отримати консультацію', '#', 'consultation-general'),
        'secondary_button' => constalt_default_button('Переглянути послуги', '#services'),
    ];
}

/**
 * Default content for the insight section.
 *
 * @return array<string, mixed>
 */
function constalt_home_insight_defaults(): array
{
    return [
        'marker_text' => 'Бізнес потребує системної навігації.',
        'title' => 'Коли власник бачить лише окремі показники — фінанси, управління або ризики —<br><strong>рішення часто приймаються всліпу.</strong>',
        'summary' => 'Повна картина з’являється тоді, коли ці елементи зведені разом.<br><strong>Саме на їх перетині виникають ситуації, що потребують участі власника:</strong>',
        'maze_image' => '2026/03/minos-2_result.webp',
        'cards' => [
            [
                'position' => 'top-left',
                'icon' => '2026/03/b2-icon-1.svg',
                'text' => 'Коли обороти ростуть, але прибутковість залишається незрозумілою.',
            ],
            [
                'position' => 'top-right',
                'icon' => '2026/03/b2-icon-2.svg',
                'text' => 'Коли бізнес переростає існуючу систему управління і вимагає переходу від ручного контролю до автономних процесів.',
            ],
            [
                'position' => 'bottom-left',
                'icon' => '2026/03/b2-icon-1.svg',
                'text' => 'Коли податкові або юридичні ризики починають реально впливати на стабільність та активи бізнесу.',
            ],
            [
                'position' => 'bottom-right',
                'icon' => '2026/03/b2-icon-2.svg',
                'text' => 'Коли компанія готується до залучення партнера, інвестора або великої угоди.',
            ],
        ],
    ];
}

/**
 * Default content for the services section.
 *
 * @return array<string, mixed>
 */
function constalt_home_services_defaults(): array
{
    return [
        'marker_text' => 'Напрямки роботи з бізнесом',
        'title' => 'Ми працюємо з ключовими системами бізнесу,<br>від яких <strong>залежать стабільність компанії сьогодні та її розвиток у майбутньому</strong>',
        'items' => [
            [
                'theme' => 'finance',
                'tab_label' => "Фінансовий консалтинг\nта управління прибутковістю",
                'title' => "<strong>Фінансовий консалтинг</strong><br>та управління прибутковістю",
                'subtitle' => 'Для власників, які прагнуть повного контролю над фінансами компанії.',
                'problem_label' => 'Проблема',
                'problem_text' => 'Відсутність повної картини, касові розриви та рішення, що приймаються інтуїтивно, а не на основі цифр.',
                'problem_tall' => 0,
                'doing_label' => 'Що ми робимо:',
                'doing_text' => 'Впроваджуємо систему <strong>управлінської звітності (P&amp;L, Cash Flow, Balance) та будуємо фінансові моделі для прогнозування.</strong>',
                'result_label' => 'Результат',
                'result_text' => 'Ви бачите реальну прибутковість кожного напрямку та приймаєте впевнені рішення на основі точних даних.',
                'image' => '2026/03/b3-ima_result.webp',
                'primary_button' => constalt_default_button('Обговорити задачу', '#', 'service-finance'),
                'secondary_button' => constalt_default_button('Детальніше', '#', 'service-finance-details'),
            ],
            [
                'theme' => 'corporate',
                'tab_label' => 'Корпоративне управління',
                'title' => '<strong>Корпоративне</strong> управління',
                'subtitle' => 'Для тих, хто переріс ручний контроль і прагне побудувати автономну систему.',
                'problem_label' => 'Проблема',
                'problem_text' => 'Всі ключові процеси замкнені на власнику, відповідальність команди розмита, а система не встигає за масштабом бізнесу.',
                'problem_tall' => 0,
                'doing_label' => 'Що ми робимо:',
                'doing_text' => 'Розподіляємо ролі між власником, партнерами та менеджментом, <strong>впроваджуємо чіткі правила прийняття рішень та систему контролю.</strong>',
                'result_label' => 'Результат',
                'result_text' => 'Налагоджена структура, де кожен знає свою зону відповідальності, а бізнес працює стабільно без вашої постійної мікроучасті.',
                'image' => '2026/03/b3-image-2_result.webp',
                'primary_button' => constalt_default_button('Обговорити задачу', '#', 'service-corporate'),
                'secondary_button' => constalt_default_button('Детальніше', '#', 'service-corporate-details'),
            ],
            [
                'theme' => 'due-diligence',
                'tab_label' => "Due Diligence та\nінвестиційний супровід",
                'title' => 'Due Diligence та<br><strong>інвестиційний супровід</strong>',
                'subtitle' => 'Підготовка до залучення капіталу, продажу частки або входу в нове партнерство.',
                'problem_label' => 'Проблема',
                'problem_text' => 'Ризики, які можуть проявитися після угоди, та слабка позиція в переговорах через недостатню підготовку.',
                'problem_tall' => 0,
                'doing_label' => 'Що ми робимо:',
                'doing_text' => '<strong>Проводимо глибокий фінансовий та юридичний аналіз (Due Diligence),</strong> виявляємо «підводні камені» та готуємо компанію до перевірки інвестором.',
                'result_label' => 'Результат',
                'result_text' => 'Укладання угоди на вигідних умовах із повним розумінням реального стану справ та захищеною позицією.',
                'image' => '2026/03/b3-image-3_result.webp',
                'primary_button' => constalt_default_button('Обговорити задачу', '#', 'service-due-diligence'),
                'secondary_button' => constalt_default_button('Детальніше', '#', 'service-due-diligence-details'),
            ],
            [
                'theme' => 'legal',
                'tab_label' => "Юридична архітектура\nта захист активів",
                'title' => '<strong>Юридична архітектура</strong><br>та захист активів',
                'subtitle' => 'Створення надійного фундаменту та оперативний захист інтересів власника.',
                'problem_label' => 'Проблема',
                'problem_text' => 'Вразливість до перевірок, рейдерства й недобросовісних партнерів; ризики через помилки в документах минулих років.',
                'problem_tall' => 1,
                'doing_label' => 'Що ми робимо:',
                'doing_text' => '<strong>Аудит ризиків:</strong> аналіз документів, структури власності та податкової історії.<br><strong>Захисна структура:</strong> розробка статутів, SHA та безпечної моделі володіння.<br><strong>Захист у спорах:</strong> підготовка заперечень і повне представництво в судах.',
                'result_label' => 'Результат',
                'result_text' => 'Юридично захищена модель бізнесу, де ви готові до будь-якого сценарію — від мирного масштабування до агресивного захисту прав у суді.',
                'image' => '2026/03/b3-image-4_result.webp',
                'primary_button' => constalt_default_button('Обговорити задачу', '#', 'service-legal'),
                'secondary_button' => constalt_default_button('Детальніше', '#', 'service-legal'),
            ],
        ],
    ];
}

/**
 * Default content for the collaboration section.
 *
 * @return array<string, mixed>
 */
function constalt_home_collaboration_defaults(): array
{
    return [
        'marker_text' => 'Як ми працюємо з бізнесом',
        'title' => '<strong>Формат співпраці залежить</strong> від задачі, масштабу змін і рівня рішень, які потрібно прийняти',
        'cards' => [
            [
                'style' => 'expert',
                'icon' => '2026/03/icon-4-1.svg',
                'title' => 'Експертна консультація',
                'subtitle' => 'Коли власнику <strong>потрібно зрозуміти реальний стан бізнесу та визначити ключові проблеми.</strong>',
                'format_label' => 'Формат',
                'format_items' => "аналіз фінансів, структури управління або ризиків\nвиявлення ключових проблем і точок росту\nрекомендації щодо подальших управлінських рішень",
                'result_label' => 'Результат',
                'result_text' => 'Чітке розуміння ситуації та план дій для власника.',
                'button' => constalt_default_button('Залишити заявку', '#', 'collaboration-expert'),
            ],
            [
                'style' => 'project',
                'icon' => '2026/03/icon-4-2.svg',
                'title' => 'Проєктна робота',
                'subtitle' => 'Коли бізнесу потрібно <strong>не лише визначити проблему, а й впровадити рішення.</strong>',
                'format_label' => 'Формат',
                'format_items' => "побудова фінансової системи\nвпровадження моделі корпоративного управління\nпідготовка до інвестицій або угоди",
                'result_label' => 'Результат',
                'result_text' => 'Рішення, які змінюють структуру управління і роботу бізнесу.',
                'button' => constalt_default_button('Залишити заявку', '#', 'collaboration-project'),
            ],
            [
                'style' => 'strategic',
                'icon' => '2026/03/icon-4-3.svg',
                'title' => 'Стратегічний супровід',
                'subtitle' => 'Коли власнику потрібен <strong>партнер для складних управлінських рішень і розвитку бізнесу.</strong>',
                'format_label' => 'Формат',
                'format_items' => "участь у стратегічних рішеннях\nрегулярні консультації\nпідтримка у ключових бізнес-ситуаціях",
                'result_label' => 'Результат',
                'result_text' => 'Експертна підтримка власника у розвитку компанії.',
                'button' => constalt_default_button('Залишити заявку', '#', 'collaboration-strategic'),
            ],
        ],
    ];
}

/**
 * Default content for the trust section.
 *
 * @return array<string, mixed>
 */
function constalt_home_trust_defaults(): array
{
    return [
        'marker_text' => 'Чому нам довіряють',
        'title' => 'Складні бізнес-рішення потребують не лише експертизи, <strong>а й правильного підходу до роботи з компанією</strong>',
        'background_left' => '2026/03/fad_result-scaled.webp',
        'background_right' => '2026/03/ChatGPT-Image-17-%D0%B1%D0%B5%D1%80.-2026-%D1%80.-20_58_12-1_result.webp',
        'items' => [
            [
                'title' => 'Бізнес як система',
                'text' => 'Не розглядаємо фінанси окремо від права чи управління — ми шукаємо першопричини, а не наслідки.',
                'active_icon' => '2026/03/a-1.svg',
                'inactive_icon' => '2026/03/na-1.svg',
            ],
            [
                'title' => 'Інтереси власника',
                'text' => 'Кожне рішення оцінюється через призму довгострокового контролю, вартості бізнесу та безпеки активів.',
                'active_icon' => '2026/03/a-2.svg',
                'inactive_icon' => '2026/03/na-2.svg',
            ],
            [
                'title' => 'Супровід до результату',
                'text' => 'Не просто даємо поради, а супроводжуємо впровадження ключових рішень у життя.',
                'active_icon' => '2026/03/a-3.svg',
                'inactive_icon' => '2026/03/na-3.svg',
            ],
            [
                'title' => 'Мова рішень, а не звітів',
                'text' => 'Ми спілкуємося мовою бізнес-результатів, а не складних юридичних формулювань.',
                'active_icon' => '2026/03/a-4.svg',
                'inactive_icon' => '2026/03/na-4.svg',
            ],
            [
                'title' => 'Практичний досвід реального бізнесу',
                'text' => 'Робота базується на управлінському і фінансовому досвіді реального бізнесу, а не лише консалтинговій теорії.',
                'active_icon' => '2026/03/a-5.svg',
                'inactive_icon' => '2026/03/na-5.svg',
            ],
            [
                'title' => 'Чесна оцінка ситуації',
                'text' => 'Завдання — показати реальний стан бізнесу, навіть коли висновки можуть бути незручними. Саме це дозволяє уникати помилок, які можуть дорого коштувати компанії.',
                'active_icon' => '2026/03/a-6.svg',
                'inactive_icon' => '2026/03/na-6.svg',
            ],
        ],
    ];
}

/**
 * Default content for the about section.
 *
 * @return array<string, mixed>
 */
function constalt_home_about_defaults(): array
{
    return [
        'marker_text' => 'Про нас',
        'title' => 'Коли стандартної експертизи<br><strong>вже недостатньо</strong>',
        'card_desktop_image' => '2026/03/phonje_result-scaled.webp',
        'card_mobile_image' => '2026/03/Frame-2087325717_result.webp',
        'lead_text' => 'Audit-Consulting працює з власниками бізнесу, <strong>які приймають складні рішення —</strong>',
        'lead_subtext' => 'щодо ризиків, партнерства, структури управління та інвестицій.',
        'plain_title' => 'Це не стандартний консалтинг і не формальні звіти.',
        'plain_text' => 'Ми підключаємося там, де рішення впливають на контроль над бізнесом, його вартість і подальший розвиток.',
        'year_prefix' => 'з',
        'year_number' => '2008',
        'year_suffix' => 'року',
        'year_text' => 'команда працює у сфері фінансів, податкового права, антикризового управління та інвестиційних процесів.',
    ];
}

/**
 * Default content for the expert section.
 *
 * @return array<string, mixed>
 */
function constalt_home_expert_defaults(): array
{
    return [
        'quote_icon' => '2026/03/1233.svg',
        'quote_text' => 'Ефективне управління починається там, де цифри трансформуються у стратегію. <strong>Мій фокус — антикризова стійкість, сценарії розвитку та захист капіталу в кожному ключовому рішенні.</strong>',
        'intro_text' => 'Audit-Consulting — бутікова стратегічна експертиза для бізнесу в точках трансформації та зростання.',
        'name' => 'Анна Левандовська',
        'role' => 'власниця і CEO Audit-Consulting',
        'details' => [
            [
                'text' => '<strong>Expertise &amp; Advisory:</strong> Стратегічний радник з питань захисту активів, антикризового управління та масштабування бізнесу.',
            ],
            [
                'text' => '<strong>Certified Corporate Director (ПАКУ):</strong> Впровадження стандартів корпоративного врядування та роботи рад директорів.',
            ],
            [
                'text' => '<strong>Executive Management &amp; Transformation:</strong> 20+ років досвіду на рівні CEO та Group CFO у виробничих, агро- та девелоперських холдингах.',
            ],
            [
                'text' => '<strong>Architecture of Change:</strong> Побудова ефективних систем управління бізнесом та цифрова трансформація.',
            ],
        ],
        'link_label' => 'Детальніше про Audit-Consulting',
        'link_url' => '#contact',
        'photo' => '2026/03/phot2_result.webp',
        'stat_label' => "управлінського\nта фінансового досвіду",
        'stat_value' => '20',
        'stat_suffix' => '+',
        'stat_years_label' => 'років',
        'badge_icon' => '2026/03/Frame-1321317016.svg',
    ];
}

/**
 * Default content for the partners section.
 *
 * @return array<string, mixed>
 */
function constalt_home_partners_defaults(): array
{
    return [
        'marker_text' => 'Партнери',
        'items' => [
            [
                'modifier' => 'paku',
                'logo' => '2026/03/br1_result.webp',
                'alt' => 'Професійна асоціація корпоративного управління',
            ],
            [
                'modifier' => 'tg',
                'logo' => '2026/03/br2_result.webp',
                'alt' => 'TG Consulting',
            ],
            [
                'modifier' => 'hbpi',
                'logo' => '2026/03/br-3_result.webp',
                'alt' => 'hbpi consulting',
            ],
            [
                'modifier' => 'auditservice',
                'logo' => '2026/03/br-4_result.webp',
                'alt' => 'Аудитсервіс',
            ],
        ],
    ];
}

/**
 * Default content for the homepage contact block.
 *
 * @return array<string, mixed>
 */
function constalt_home_contact_defaults(): array
{
    return [
        'title' => 'У бізнесі важливо бачити<br><strong>повну картину</strong>',
        'description' => 'Якщо у вас є питання щодо фінансів, структури управління чи розвитку компанії — <strong>обговоримо ситуацію та можливі рішення.</strong>',
        'name_placeholder' => 'Ваше імʼя',
        'phone_placeholder' => 'Номер телефону',
        'question_placeholder' => 'Ваше запитання',
        'consent_label' => 'Я погоджуюсь з політикою конфіденційності',
        'submit_label' => 'Запланувати розмову',
        'background_image' => '2026/03/Frame-2087325608_result.webp',
    ];
}

/**
 * Default content for the FAQ section.
 *
 * @return array<string, mixed>
 */
function constalt_home_faq_defaults(): array
{
    return [
        'marker_text' => 'Поширені питання',
        'title' => 'Нас часто <strong>запитують</strong>',
        'items' => [
            [
                'question' => 'З чого починається співпраця?',
                'answer' => 'Первинна зустріч допомагає окреслити контекст запиту, ключові обмеження та бажаний результат. Далі формуємо формат роботи, етапи і пріоритети дій.',
            ],
            [
                'question' => 'Чи працюєте ви конфіденційно?',
                'answer' => 'Так, конфіденційність є базовим принципом взаємодії. Робота ведеться у захищеному контурі з фіксацією правил доступу до даних і комунікації.',
            ],
            [
                'question' => 'Чи супроводжуєте ви впровадження, чи лише надаєте рекомендації?',
                'answer' => 'Формат гнучкий: від експертного висновку до повного супроводу впровадження. У фокусі не тільки рішення, а й фактичний результат у бізнес-процесах.',
            ],
            [
                'question' => 'Коли варто звертатися — під час кризи чи до неї?',
                'answer' => 'Оптимально звертатися на ранніх сигналах змін, але й у кризовій фазі можна швидко стабілізувати ситуацію. Підхід залежить від масштабу ризиків та часу на рішення.',
            ],
            [
                'question' => 'Чи можна залучити вас для разового запиту?',
                'answer' => 'Так, можливий точковий формат для конкретного управлінського питання. За потреби його можна масштабувати у довший проєктний або стратегічний супровід.',
            ],
            [
                'question' => 'З чого почати, якщо ситуація виглядає заплутаною?',
                'answer' => 'Почніть із короткого опису симптомів та ключових рішень, що вас турбують. На першому етапі структуруємо проблему і визначаємо, де саме потрібне втручання.',
            ],
        ],
        'cta_title' => 'Не всі управлінські запити можна описати типово',
        'cta_text' => 'Якщо ваша ситуація потребує окремого розгляду — залиште запит для первинної оцінки.',
        'cta_button' => constalt_default_button('Отримати консультацію', '#', 'consultation-general'),
    ];
}

/**
 * Default content for the homepage blog section.
 *
 * @return array<string, mixed>
 */
function constalt_home_blog_defaults(): array
{
    return [
        'marker_text' => 'Блог',
        'title' => 'Експертиза і новини',
        'all_link_label' => 'Усі новини',
        'empty_text' => 'Додайте записи блогу, щоб показати цей блок.',
    ];
}

/**
 * Default content for the contacts page.
 *
 * @return array<string, mixed>
 */
function constalt_contacts_page_defaults(): array
{
    return [
        'marker_text' => 'Контакти',
        'title' => "Способи зв'язку",
        'phone_label' => 'Телефон',
        'phone_value' => '+38 075 195 50 02',
        'socials' => [
            [
                'network' => 'telegram',
                'url' => '#',
                'aria_label' => 'Telegram',
                'custom_icon' => '',
            ],
            [
                'network' => 'instagram',
                'url' => '#',
                'aria_label' => 'Instagram',
                'custom_icon' => '',
            ],
            [
                'network' => 'viber',
                'url' => '#',
                'aria_label' => 'Viber',
                'custom_icon' => '',
            ],
            [
                'network' => 'facebook',
                'url' => '#',
                'aria_label' => 'Facebook',
                'custom_icon' => '',
            ],
        ],
        'address_label' => 'Адреса',
        'address_text' => 'м. Київ, вул. Шота Руставелі, буд. 24, оф. 18',
        'hours_label' => 'Графік роботи',
        'hours_text' => 'Пн-Пт з 9.00 до 18.00',
        'panel_title' => 'Потрібна консультація?',
        'panel_description' => 'Залиште заявку і ми допоможемо з усім розібратись.',
        'form_service' => 'Контакти: консультація',
        'name_placeholder' => 'Ваше імʼя',
        'phone_placeholder' => 'Номер телефону',
        'question_placeholder' => 'Ваше запитання',
        'consent_label' => 'Я погоджуюсь з політикою конфіденційності',
        'submit_label' => 'Отримати консультацію',
    ];
}

/**
 * Returns home hero content.
 */
function constalt_get_home_hero_content(): array
{
    return constalt_get_option_group('constalt_home_hero', constalt_home_hero_defaults());
}

/**
 * Returns home insight content.
 */
function constalt_get_home_insight_content(): array
{
    return constalt_get_option_group('constalt_home_insight', constalt_home_insight_defaults());
}

/**
 * Returns home services content.
 */
function constalt_get_home_services_content(): array
{
    return constalt_get_option_group('constalt_home_services', constalt_home_services_defaults());
}

/**
 * Returns home collaboration content.
 */
function constalt_get_home_collaboration_content(): array
{
    return constalt_get_option_group('constalt_home_collaboration', constalt_home_collaboration_defaults());
}

/**
 * Returns home trust content.
 */
function constalt_get_home_trust_content(): array
{
    return constalt_get_option_group('constalt_home_trust', constalt_home_trust_defaults());
}

/**
 * Returns home about content.
 */
function constalt_get_home_about_content(): array
{
    return constalt_get_option_group('constalt_home_about', constalt_home_about_defaults());
}

/**
 * Returns home expert content.
 */
function constalt_get_home_expert_content(): array
{
    return constalt_get_option_group('constalt_home_expert', constalt_home_expert_defaults());
}

/**
 * Returns home partners content.
 */
function constalt_get_home_partners_content(): array
{
    return constalt_get_option_group('constalt_home_partners', constalt_home_partners_defaults());
}

/**
 * Returns home contact content.
 */
function constalt_get_home_contact_content(): array
{
    return constalt_get_option_group('constalt_home_contact', constalt_home_contact_defaults());
}

/**
 * Returns home FAQ content.
 */
function constalt_get_home_faq_content(): array
{
    return constalt_get_option_group('constalt_home_faq', constalt_home_faq_defaults());
}

/**
 * Returns home blog content.
 */
function constalt_get_home_blog_content(): array
{
    return constalt_get_option_group('constalt_home_blog', constalt_home_blog_defaults());
}

/**
 * Returns contacts page content.
 */
function constalt_get_contacts_page_content(): array
{
    return constalt_get_option_group('constalt_contacts_page', constalt_contacts_page_defaults());
}

/**
 * Maps option group field names to their default providers.
 *
 * @return array<string, string>
 */
function constalt_acf_option_default_map(): array
{
    return [
        'constalt_home_hero' => 'constalt_home_hero_defaults',
        'constalt_home_insight' => 'constalt_home_insight_defaults',
        'constalt_home_services' => 'constalt_home_services_defaults',
        'constalt_home_collaboration' => 'constalt_home_collaboration_defaults',
        'constalt_home_trust' => 'constalt_home_trust_defaults',
        'constalt_home_about' => 'constalt_home_about_defaults',
        'constalt_home_expert' => 'constalt_home_expert_defaults',
        'constalt_home_partners' => 'constalt_home_partners_defaults',
        'constalt_home_contact' => 'constalt_home_contact_defaults',
        'constalt_home_faq' => 'constalt_home_faq_defaults',
        'constalt_home_blog' => 'constalt_home_blog_defaults',
        'constalt_contacts_page' => 'constalt_contacts_page_defaults',
    ];
}

/**
 * Pre-populates ACF option groups with current site defaults on first open.
 *
 * @param mixed                $value
 * @param string|int           $post_id
 * @param array<string, mixed> $field
 * @return mixed
 */
function constalt_acf_load_default_option_group($value, $post_id, array $field)
{
    if (($value !== null && $value !== false && $value !== '') || ($field['type'] ?? '') !== 'group') {
        return $value;
    }

    $name = isset($field['name']) ? (string) $field['name'] : '';
    $map = constalt_acf_option_default_map();

    if (! isset($map[$name]) || ! function_exists($map[$name])) {
        return $value;
    }

    $provider = $map[$name];

    return $provider();
}
add_filter('acf/load_value', 'constalt_acf_load_default_option_group', 20, 3);

/**
 * Returns a built-in social icon SVG.
 */
function constalt_get_social_icon_svg(string $network): string
{
    $icons = [
        'telegram' => '<svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M20.76 4.2 3.95 10.68c-1.15.47-1.14 1.11-.2 1.39l4.31 1.34 9.96-6.28c.47-.29.9-.13.55.18l-8.07 7.29-.3 4.53c.44 0 .64-.2.89-.44l2.15-2.09 4.47 3.3c.83.46 1.42.22 1.63-.77l2.86-13.48c.31-1.21-.47-1.76-1.34-1.37z"/></svg>',
        'instagram' => '<svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm0 1.9A3.9 3.9 0 0 0 3.9 7.8v8.4a3.9 3.9 0 0 0 3.9 3.9h8.4a3.9 3.9 0 0 0 3.9-3.9V7.8a3.9 3.9 0 0 0-3.9-3.9H7.8zm8.86 1.43a1.34 1.34 0 1 1 0 2.68 1.34 1.34 0 0 1 0-2.68zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 1.9A3.1 3.1 0 1 0 12 15.1 3.1 3.1 0 0 0 12 8.9z"/></svg>',
        'viber' => '<svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M11.7 3C7 3 3.4 6.2 3.4 10.4c0 2.4 1.2 4.6 3.2 6l-.7 3 3.1-1.7c.9.2 1.8.3 2.7.3 4.7 0 8.3-3.2 8.3-7.4S16.4 3 11.7 3zm4.3 9.7c-.2.5-1 .9-1.4 1-.4.1-.9.1-1.4-.1-.3-.1-.7-.2-1.2-.4-2.1-.9-3.5-3.2-3.6-3.3-.1-.1-.9-1.2-.9-2.2 0-1 .5-1.5.7-1.7.2-.2.4-.2.5-.2h.4c.1 0 .3 0 .4.3.2.5.6 1.6.6 1.7.1.1.1.3 0 .4-.1.1-.1.3-.3.4l-.2.3c-.1.1-.1.2 0 .4.1.1.5.9 1.1 1.4.8.7 1.4 1 1.6 1.1.2.1.3.1.5-.1.1-.1.5-.6.6-.8.2-.2.3-.2.5-.1.2.1 1.2.6 1.4.7.2.1.4.2.4.3.1.2.1.8-.1 1.3z"/></svg>',
        'facebook' => '<svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.5 22v-8h2.6l.4-3h-3V9.1c0-.86.24-1.45 1.48-1.45H16.6V5a22.2 22.2 0 0 0-2.46-.13c-2.44 0-4.1 1.49-4.1 4.22V11H7.4v3h2.64v8h3.46z"/></svg>',
        'linkedin' => '<svg class="contacts-page__social-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.94 8.5H3.56V20h3.38V8.5zM5.25 3A1.97 1.97 0 1 0 5.3 6.94 1.97 1.97 0 0 0 5.25 3zm15.19 9.96c0-3.45-1.84-5.05-4.29-5.05-1.98 0-2.87 1.09-3.37 1.86V8.5H9.41c.04.84 0 11.5 0 11.5h3.37v-6.42c0-.34.03-.67.12-.91.27-.67.88-1.36 1.9-1.36 1.34 0 1.88 1.02 1.88 2.52V20H20V12.96h.44z"/></svg>',
    ];

    return $icons[$network] ?? $icons['telegram'];
}

/**
 * Creates a reusable ACF field definition.
 *
 * @param array<string, mixed> $settings
 * @return array<string, mixed>
 */
function constalt_acf_field(string $key_base, string $label, string $name, string $type, array $settings = []): array
{
    return array_merge(
        [
            'key' => 'field_constalt_' . $key_base,
            'label' => $label,
            'name' => $name,
            'type' => $type,
        ],
        $settings
    );
}

/**
 * Creates a reusable ACF tab field.
 *
 * @return array<string, mixed>
 */
function constalt_acf_tab(string $key_base, string $label): array
{
    return [
        'key' => 'field_constalt_' . $key_base,
        'label' => $label,
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ];
}

/**
 * Creates a reusable ACF group field.
 *
 * @param array<int, array<string, mixed>> $sub_fields
 * @param array<string, mixed>             $settings
 * @return array<string, mixed>
 */
function constalt_acf_group(string $key_base, string $label, string $name, array $sub_fields, array $settings = []): array
{
    return array_merge(
        [
            'key' => 'field_constalt_' . $key_base,
            'label' => $label,
            'name' => $name,
            'type' => 'group',
            'layout' => 'block',
            'sub_fields' => $sub_fields,
        ],
        $settings
    );
}

/**
 * Creates a reusable ACF repeater field.
 *
 * @param array<int, array<string, mixed>> $sub_fields
 * @param array<string, mixed>             $settings
 * @return array<string, mixed>
 */
function constalt_acf_repeater(string $key_base, string $label, string $name, array $sub_fields, array $settings = []): array
{
    return array_merge(
        [
            'key' => 'field_constalt_' . $key_base,
            'label' => $label,
            'name' => $name,
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Додати елемент',
            'sub_fields' => $sub_fields,
        ],
        $settings
    );
}

/**
 * Creates a standard button sub-group.
 *
 * @return array<string, mixed>
 */
function constalt_acf_button_group(string $key_base, string $label, string $name, array $defaults): array
{
    return constalt_acf_group(
        $key_base,
        $label,
        $name,
        [
            constalt_acf_field($key_base . '_label', 'Текст кнопки', 'label', 'text', [
                'default_value' => $defaults['label'] ?? '',
            ]),
            constalt_acf_field($key_base . '_url', 'Посилання / якір', 'url', 'text', [
                'default_value' => $defaults['url'] ?? '',
                'instructions' => 'Можна вказати URL, відносне посилання або якір на кшталт #services.',
            ]),
            constalt_acf_field($key_base . '_popup_key', 'Ключ popup', 'popup_key', 'text', [
                'default_value' => $defaults['popup_key'] ?? '',
                'instructions' => 'Якщо поле заповнене, кнопка відкриє popup за цим ключем.',
            ]),
        ]
    );
}

/**
 * Registers ACF options pages for site content.
 */
function constalt_register_site_content_options_pages(): void
{
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(
        [
            'page_title' => 'Контент сайту',
            'menu_title' => 'Контент сайту',
            'menu_slug' => 'constalt-site-content',
            'capability' => 'edit_posts',
            'redirect' => true,
            'icon_url' => 'dashicons-layout',
            'position' => 25,
        ]
    );

    acf_add_options_sub_page(
        [
            'page_title' => 'Головна',
            'menu_title' => 'Головна',
            'parent_slug' => 'constalt-site-content',
            'menu_slug' => 'constalt-home-content',
            'capability' => 'edit_posts',
        ]
    );

    acf_add_options_sub_page(
        [
            'page_title' => 'Контакти',
            'menu_title' => 'Контакти',
            'parent_slug' => 'constalt-site-content',
            'menu_slug' => 'constalt-contacts-content',
            'capability' => 'edit_posts',
        ]
    );
}
add_action('acf/init', 'constalt_register_site_content_options_pages');

/**
 * Registers ACF field groups for the site content options pages.
 */
function constalt_register_site_content_field_groups(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    $hero_defaults = constalt_home_hero_defaults();
    $insight_defaults = constalt_home_insight_defaults();
    $services_defaults = constalt_home_services_defaults();
    $collaboration_defaults = constalt_home_collaboration_defaults();
    $trust_defaults = constalt_home_trust_defaults();
    $about_defaults = constalt_home_about_defaults();
    $expert_defaults = constalt_home_expert_defaults();
    $partners_defaults = constalt_home_partners_defaults();
    $contact_defaults = constalt_home_contact_defaults();
    $faq_defaults = constalt_home_faq_defaults();
    $blog_defaults = constalt_home_blog_defaults();
    $contacts_defaults = constalt_contacts_page_defaults();

    acf_add_local_field_group(
        [
            'key' => 'group_constalt_home_content',
            'title' => 'Контент головної сторінки',
            'fields' => [
                constalt_acf_tab('home_tab_hero', 'Головний екран'),
                constalt_acf_group(
                    'home_hero_group',
                    'Головний екран',
                    'constalt_home_hero',
                    [
                        constalt_acf_field('home_hero_preview_text', 'Текст над заголовком', 'preview_text', 'text', [
                            'default_value' => $hero_defaults['preview_text'],
                        ]),
                        constalt_acf_field('home_hero_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $hero_defaults['title'],
                            'rows' => 4,
                            'instructions' => 'Кожен новий рядок стане окремим рядком заголовка. Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_hero_description', 'Опис', 'description', 'textarea', [
                            'default_value' => $hero_defaults['description'],
                            'rows' => 3,
                        ]),
                        constalt_acf_field('home_hero_desktop_poster', 'Постер для десктопу', 'desktop_poster', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_hero_mobile_poster', 'Постер для мобільної версії', 'mobile_poster', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_hero_desktop_video', 'Відео для десктопу', 'desktop_video', 'file', [
                            'return_format' => 'array',
                            'mime_types' => 'mp4,mov,webm',
                        ]),
                        constalt_acf_field('home_hero_mobile_video', 'Відео для мобільної версії', 'mobile_video', 'file', [
                            'return_format' => 'array',
                            'mime_types' => 'mp4,mov,webm',
                        ]),
                        constalt_acf_button_group('home_hero_primary_button', 'Основна кнопка', 'primary_button', $hero_defaults['primary_button']),
                        constalt_acf_button_group('home_hero_secondary_button', 'Додаткова кнопка', 'secondary_button', $hero_defaults['secondary_button']),
                    ]
                ),

                constalt_acf_tab('home_tab_insight', 'Інсайт'),
                constalt_acf_group(
                    'home_insight_group',
                    'Інсайт-блок',
                    'constalt_home_insight',
                    [
                        constalt_acf_field('home_insight_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $insight_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_insight_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $insight_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_insight_summary', 'Підзаголовок', 'summary', 'textarea', [
                            'default_value' => $insight_defaults['summary'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_insight_maze_image', 'Фонове зображення лабіринту', 'maze_image', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_repeater(
                            'home_insight_cards',
                            'Картки поверх лабіринту',
                            'cards',
                            [
                                constalt_acf_field('home_insight_card_position', 'Позиція', 'position', 'select', [
                                    'choices' => [
                                        'top-left' => 'Ліворуч зверху',
                                        'top-right' => 'Праворуч зверху',
                                        'bottom-left' => 'Ліворуч знизу',
                                        'bottom-right' => 'Праворуч знизу',
                                    ],
                                    'default_value' => 'top-left',
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('home_insight_card_icon', 'Иконка', 'icon', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                ]),
                                constalt_acf_field('home_insight_card_text', 'Текст', 'text', 'textarea', [
                                    'rows' => 2,
                                ]),
                            ],
                            [
                                'button_label' => 'Додати картку',
                            ]
                        ),
                    ]
                ),

                constalt_acf_tab('home_tab_services', 'Послуги'),
                constalt_acf_group(
                    'home_services_group',
                    'Блок послуг',
                    'constalt_home_services',
                    [
                        constalt_acf_field('home_services_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $services_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_services_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $services_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_repeater(
                            'home_services_items',
                            'Картки послуг',
                            'items',
                            [
                                constalt_acf_field('home_services_item_theme', 'Тема картки', 'theme', 'select', [
                                    'choices' => [
                                        'finance' => 'Фінанси',
                                        'corporate' => 'Корпоративне управління',
                                        'due-diligence' => 'Due Diligence',
                                        'legal' => 'Юридичний блок',
                                    ],
                                    'default_value' => 'finance',
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('home_services_item_tab_label', 'Текст табу', 'tab_label', 'textarea', [
                                    'rows' => 2,
                                    'instructions' => 'Перенесення рядка дозволене.',
                                ]),
                                constalt_acf_field('home_services_item_title', 'Заголовок картки', 'title', 'textarea', [
                                    'rows' => 3,
                                    'instructions' => 'Дозволені <strong> і <br>.',
                                ]),
                                constalt_acf_field('home_services_item_subtitle', 'Підзаголовок', 'subtitle', 'textarea', [
                                    'rows' => 2,
                                ]),
                                constalt_acf_field('home_services_item_problem_label', 'Підпис блоку проблеми', 'problem_label', 'text', [
                                    'default_value' => 'Проблема',
                                ]),
                                constalt_acf_field('home_services_item_problem_text', 'Текст проблеми', 'problem_text', 'textarea', [
                                    'rows' => 3,
                                ]),
                                constalt_acf_field('home_services_item_problem_tall', 'Високий блок проблеми', 'problem_tall', 'true_false', [
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('home_services_item_doing_label', 'Підпис блоку "Що робимо"', 'doing_label', 'text', [
                                    'default_value' => 'Що ми робимо:',
                                ]),
                                constalt_acf_field('home_services_item_doing_text', 'Текст "Що робимо"', 'doing_text', 'textarea', [
                                    'rows' => 4,
                                    'instructions' => 'Дозволені <strong> і <br>.',
                                ]),
                                constalt_acf_field('home_services_item_result_label', 'Підпис результату', 'result_label', 'text', [
                                    'default_value' => 'Результат',
                                ]),
                                constalt_acf_field('home_services_item_result_text', 'Текст результату', 'result_text', 'textarea', [
                                    'rows' => 3,
                                ]),
                                constalt_acf_field('home_services_item_image', 'Зображення', 'image', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'medium',
                                ]),
                                constalt_acf_button_group('home_services_item_primary_button', 'Основна кнопка', 'primary_button', constalt_default_button('Обговорити задачу')),
                                constalt_acf_button_group('home_services_item_secondary_button', 'Додаткова кнопка', 'secondary_button', constalt_default_button('Детальніше')),
                            ],
                            [
                                'button_label' => 'Додати послугу',
                            ]
                        ),
                    ]
                ),

                constalt_acf_tab('home_tab_collaboration', 'Співпраця'),
                constalt_acf_group(
                    'home_collaboration_group',
                    'Блок форматів співпраці',
                    'constalt_home_collaboration',
                    [
                        constalt_acf_field('home_collaboration_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $collaboration_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_collaboration_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $collaboration_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_repeater(
                            'home_collaboration_cards',
                            'Картки',
                            'cards',
                            [
                                constalt_acf_field('home_collaboration_card_style', 'Стиль картки', 'style', 'select', [
                                    'choices' => [
                                        'expert' => 'Темна / Експертна консультація',
                                        'project' => 'Світла / Проєктна робота',
                                        'strategic' => 'Градієнт / Стратегічний супровід',
                                    ],
                                    'default_value' => 'expert',
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('home_collaboration_card_icon', 'Иконка', 'icon', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                ]),
                                constalt_acf_field('home_collaboration_card_title', 'Заголовок', 'title', 'text'),
                                constalt_acf_field('home_collaboration_card_subtitle', 'Підзаголовок', 'subtitle', 'textarea', [
                                    'rows' => 3,
                                    'instructions' => 'Дозволені <strong> і <br>.',
                                ]),
                                constalt_acf_field('home_collaboration_card_format_label', 'Підпис списку', 'format_label', 'text', [
                                    'default_value' => 'Формат',
                                ]),
                                constalt_acf_field('home_collaboration_card_format_items', 'Список формату', 'format_items', 'textarea', [
                                    'rows' => 4,
                                    'instructions' => 'Кожен новий рядок стане окремим пунктом.',
                                ]),
                                constalt_acf_field('home_collaboration_card_result_label', 'Підпис результату', 'result_label', 'text', [
                                    'default_value' => 'Результат',
                                ]),
                                constalt_acf_field('home_collaboration_card_result_text', 'Текст результату', 'result_text', 'textarea', [
                                    'rows' => 2,
                                ]),
                                constalt_acf_button_group('home_collaboration_card_button', 'Кнопка', 'button', constalt_default_button('Залишити заявку')),
                            ],
                            [
                                'button_label' => 'Додати картку',
                            ]
                        ),
                    ]
                ),

                constalt_acf_tab('home_tab_trust', 'Довіра'),
                constalt_acf_group(
                    'home_trust_group',
                    'Блок довіри',
                    'constalt_home_trust',
                    [
                        constalt_acf_field('home_trust_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $trust_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_trust_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $trust_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_trust_background_left', 'Лівий фон', 'background_left', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_trust_background_right', 'Правий фон', 'background_right', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_repeater(
                            'home_trust_items',
                            'Пункти таймлайну',
                            'items',
                            [
                                constalt_acf_field('home_trust_item_title', 'Заголовок', 'title', 'text'),
                                constalt_acf_field('home_trust_item_text', 'Текст', 'text', 'textarea', [
                                    'rows' => 3,
                                ]),
                                constalt_acf_field('home_trust_item_active_icon', 'Іконка активного стану', 'active_icon', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                ]),
                                constalt_acf_field('home_trust_item_inactive_icon', 'Іконка звичайного стану', 'inactive_icon', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                ]),
                            ],
                            [
                                'button_label' => 'Додати пункт',
                            ]
                        ),
                    ]
                ),

                constalt_acf_tab('home_tab_about', 'Про нас'),
                constalt_acf_group(
                    'home_about_group',
                    'Блок про компанію',
                    'constalt_home_about',
                    [
                        constalt_acf_field('home_about_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $about_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_about_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $about_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_about_card_desktop_image', 'Фон картки для десктопу', 'card_desktop_image', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_about_card_mobile_image', 'Фон картки для мобільної версії', 'card_mobile_image', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_about_lead_text', 'Текст у скляній картці', 'lead_text', 'textarea', [
                            'default_value' => $about_defaults['lead_text'],
                            'rows' => 2,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_about_lead_subtext', 'Другий рядок скляної картки', 'lead_subtext', 'textarea', [
                            'default_value' => $about_defaults['lead_subtext'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('home_about_plain_title', 'Заголовок нижнього тексту', 'plain_title', 'textarea', [
                            'default_value' => $about_defaults['plain_title'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('home_about_plain_text', 'Нижній текст', 'plain_text', 'textarea', [
                            'default_value' => $about_defaults['plain_text'],
                            'rows' => 3,
                        ]),
                        constalt_acf_field('home_about_year_prefix', 'Префікс року', 'year_prefix', 'text', [
                            'default_value' => $about_defaults['year_prefix'],
                        ]),
                        constalt_acf_field('home_about_year_number', 'Рік', 'year_number', 'text', [
                            'default_value' => $about_defaults['year_number'],
                        ]),
                        constalt_acf_field('home_about_year_suffix', 'Суфікс року', 'year_suffix', 'text', [
                            'default_value' => $about_defaults['year_suffix'],
                        ]),
                        constalt_acf_field('home_about_year_text', 'Текст біля року', 'year_text', 'textarea', [
                            'default_value' => $about_defaults['year_text'],
                            'rows' => 3,
                        ]),
                    ]
                ),

                constalt_acf_tab('home_tab_expert', 'Експерт'),
                constalt_acf_group(
                    'home_expert_group',
                    'Блок експерта',
                    'constalt_home_expert',
                    [
                        constalt_acf_field('home_expert_quote_icon', 'Іконка цитати', 'quote_icon', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                        ]),
                        constalt_acf_field('home_expert_quote_text', 'Цитата', 'quote_text', 'textarea', [
                            'default_value' => $expert_defaults['quote_text'],
                            'rows' => 4,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_expert_intro_text', 'Вступ', 'intro_text', 'textarea', [
                            'default_value' => $expert_defaults['intro_text'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('home_expert_name', 'Ім’я', 'name', 'text', [
                            'default_value' => $expert_defaults['name'],
                        ]),
                        constalt_acf_field('home_expert_role', 'Роль', 'role', 'text', [
                            'default_value' => $expert_defaults['role'],
                        ]),
                        constalt_acf_repeater(
                            'home_expert_details',
                            'Список компетенцій',
                            'details',
                            [
                                constalt_acf_field('home_expert_detail_text', 'Текст пункту', 'text', 'textarea', [
                                    'rows' => 3,
                                    'instructions' => 'Дозволені <strong> і <br>.',
                                ]),
                            ],
                            [
                                'button_label' => 'Додати пункт',
                            ]
                        ),
                        constalt_acf_field('home_expert_link_label', 'Текст посилання', 'link_label', 'text', [
                            'default_value' => $expert_defaults['link_label'],
                        ]),
                        constalt_acf_field('home_expert_link_url', 'Посилання', 'link_url', 'text', [
                            'default_value' => $expert_defaults['link_url'],
                            'instructions' => 'Можна вказати URL, відносне посилання або якір на кшталт #contact.',
                        ]),
                        constalt_acf_field('home_expert_photo', 'Фото експерта', 'photo', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                        constalt_acf_field('home_expert_stat_label', 'Підпис статистики', 'stat_label', 'textarea', [
                            'default_value' => $expert_defaults['stat_label'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('home_expert_stat_value', 'Число', 'stat_value', 'text', [
                            'default_value' => $expert_defaults['stat_value'],
                        ]),
                        constalt_acf_field('home_expert_stat_suffix', 'Суфікс числа', 'stat_suffix', 'text', [
                            'default_value' => $expert_defaults['stat_suffix'],
                        ]),
                        constalt_acf_field('home_expert_stat_years_label', 'Підпис біля числа', 'stat_years_label', 'text', [
                            'default_value' => $expert_defaults['stat_years_label'],
                        ]),
                        constalt_acf_field('home_expert_badge_icon', 'Іконка badge', 'badge_icon', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'thumbnail',
                        ]),
                    ]
                ),

                constalt_acf_tab('home_tab_partners', 'Партнери'),
                constalt_acf_group(
                    'home_partners_group',
                    'Блок партнерів',
                    'constalt_home_partners',
                    [
                        constalt_acf_field('home_partners_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $partners_defaults['marker_text'],
                        ]),
                        constalt_acf_repeater(
                            'home_partners_items',
                            'Логотипи',
                            'items',
                            [
                                constalt_acf_field('home_partners_item_modifier', 'Розмір / стиль', 'modifier', 'select', [
                                    'choices' => [
                                        'paku' => 'Paku',
                                        'tg' => 'TG',
                                        'hbpi' => 'HBPI',
                                        'auditservice' => 'Auditservice',
                                        'default' => 'Звичайний',
                                    ],
                                    'default_value' => 'default',
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('home_partners_item_logo', 'Логотип', 'logo', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'medium',
                                ]),
                                constalt_acf_field('home_partners_item_alt', 'Alt-текст', 'alt', 'text'),
                            ],
                            [
                                'button_label' => 'Додати логотип',
                            ]
                        ),
                    ]
                ),

                constalt_acf_tab('home_tab_contact', 'Контактна форма'),
                constalt_acf_group(
                    'home_contact_group',
                    'Форма на головній',
                    'constalt_home_contact',
                    [
                        constalt_acf_field('home_contact_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $contact_defaults['title'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_contact_description', 'Опис', 'description', 'textarea', [
                            'default_value' => $contact_defaults['description'],
                            'rows' => 3,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_field('home_contact_name_placeholder', 'Підказка для імені', 'name_placeholder', 'text', [
                            'default_value' => $contact_defaults['name_placeholder'],
                        ]),
                        constalt_acf_field('home_contact_phone_placeholder', 'Підказка для телефону', 'phone_placeholder', 'text', [
                            'default_value' => $contact_defaults['phone_placeholder'],
                        ]),
                        constalt_acf_field('home_contact_question_placeholder', 'Підказка для запитання', 'question_placeholder', 'text', [
                            'default_value' => $contact_defaults['question_placeholder'],
                        ]),
                        constalt_acf_field('home_contact_consent_label', 'Текст згоди', 'consent_label', 'text', [
                            'default_value' => $contact_defaults['consent_label'],
                        ]),
                        constalt_acf_field('home_contact_submit_label', 'Текст кнопки', 'submit_label', 'text', [
                            'default_value' => $contact_defaults['submit_label'],
                        ]),
                        constalt_acf_field('home_contact_background_image', 'Фото у правій частині', 'background_image', 'image', [
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                        ]),
                    ]
                ),

                constalt_acf_tab('home_tab_faq', 'Поширені питання'),
                constalt_acf_group(
                    'home_faq_group',
                    'FAQ-блок',
                    'constalt_home_faq',
                    [
                        constalt_acf_field('home_faq_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $faq_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_faq_title', 'Заголовок', 'title', 'textarea', [
                            'default_value' => $faq_defaults['title'],
                            'rows' => 2,
                            'instructions' => 'Дозволені <strong> і <br>.',
                        ]),
                        constalt_acf_repeater(
                            'home_faq_items',
                            'Питання та відповіді',
                            'items',
                            [
                                constalt_acf_field('home_faq_item_question', 'Питання', 'question', 'text'),
                                constalt_acf_field('home_faq_item_answer', 'Відповідь', 'answer', 'textarea', [
                                    'rows' => 3,
                                    'instructions' => 'Дозволені <strong> і <br>.',
                                ]),
                            ],
                            [
                                'button_label' => 'Додати питання',
                            ]
                        ),
                        constalt_acf_field('home_faq_cta_title', 'Заголовок CTA', 'cta_title', 'text', [
                            'default_value' => $faq_defaults['cta_title'],
                        ]),
                        constalt_acf_field('home_faq_cta_text', 'Текст CTA', 'cta_text', 'textarea', [
                            'default_value' => $faq_defaults['cta_text'],
                            'rows' => 2,
                        ]),
                        constalt_acf_button_group('home_faq_cta_button', 'Кнопка CTA', 'cta_button', $faq_defaults['cta_button']),
                    ]
                ),

                constalt_acf_tab('home_tab_blog', 'Блог'),
                constalt_acf_group(
                    'home_blog_group',
                    'Блог-блок',
                    'constalt_home_blog',
                    [
                        constalt_acf_field('home_blog_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $blog_defaults['marker_text'],
                        ]),
                        constalt_acf_field('home_blog_title', 'Заголовок', 'title', 'text', [
                            'default_value' => $blog_defaults['title'],
                        ]),
                        constalt_acf_field('home_blog_all_link_label', 'Текст посилання "Усі новини"', 'all_link_label', 'text', [
                            'default_value' => $blog_defaults['all_link_label'],
                        ]),
                        constalt_acf_field('home_blog_empty_text', 'Текст для порожнього блогу', 'empty_text', 'text', [
                            'default_value' => $blog_defaults['empty_text'],
                        ]),
                    ]
                ),
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'constalt-home-content',
                    ],
                ],
            ],
            'style' => 'seamless',
            'position' => 'normal',
            'instruction_placement' => 'field',
            'active' => true,
        ]
    );

    acf_add_local_field_group(
        [
            'key' => 'group_constalt_contacts_content',
            'title' => 'Контент сторінки контактів',
            'fields' => [
                constalt_acf_tab('contacts_tab_main', 'Контакти'),
                constalt_acf_group(
                    'contacts_page_group',
                    'Сторінка контактів',
                    'constalt_contacts_page',
                    [
                        constalt_acf_field('contacts_page_marker_text', 'Маркер', 'marker_text', 'text', [
                            'default_value' => $contacts_defaults['marker_text'],
                        ]),
                        constalt_acf_field('contacts_page_title', 'Заголовок', 'title', 'text', [
                            'default_value' => $contacts_defaults['title'],
                        ]),
                        constalt_acf_field('contacts_page_phone_label', 'Підпис телефону', 'phone_label', 'text', [
                            'default_value' => $contacts_defaults['phone_label'],
                        ]),
                        constalt_acf_field('contacts_page_phone_value', 'Телефон', 'phone_value', 'text', [
                            'default_value' => $contacts_defaults['phone_value'],
                        ]),
                        constalt_acf_repeater(
                            'contacts_page_socials',
                            'Соцмережі',
                            'socials',
                            [
                                constalt_acf_field('contacts_page_social_network', 'Мережа', 'network', 'select', [
                                    'choices' => [
                                        'telegram' => 'Telegram',
                                        'instagram' => 'Instagram',
                                        'viber' => 'Viber',
                                        'facebook' => 'Facebook',
                                        'linkedin' => 'LinkedIn',
                                        'custom' => 'Власна іконка',
                                    ],
                                    'default_value' => 'telegram',
                                    'ui' => 1,
                                ]),
                                constalt_acf_field('contacts_page_social_url', 'Посилання', 'url', 'text', [
                                    'instructions' => 'Можна вставити https://, tg://, viber:// або тимчасово #.',
                                ]),
                                constalt_acf_field('contacts_page_social_aria_label', 'Aria-мітка', 'aria_label', 'text'),
                                constalt_acf_field('contacts_page_social_custom_icon', 'Власна іконка', 'custom_icon', 'image', [
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                ]),
                            ],
                            [
                                'button_label' => 'Додати соцмережу',
                            ]
                        ),
                        constalt_acf_field('contacts_page_address_label', 'Підпис адреси', 'address_label', 'text', [
                            'default_value' => $contacts_defaults['address_label'],
                        ]),
                        constalt_acf_field('contacts_page_address_text', 'Адреса', 'address_text', 'textarea', [
                            'default_value' => $contacts_defaults['address_text'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('contacts_page_hours_label', 'Підпис графіка', 'hours_label', 'text', [
                            'default_value' => $contacts_defaults['hours_label'],
                        ]),
                        constalt_acf_field('contacts_page_hours_text', 'Графік', 'hours_text', 'textarea', [
                            'default_value' => $contacts_defaults['hours_text'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('contacts_page_panel_title', 'Заголовок форми', 'panel_title', 'text', [
                            'default_value' => $contacts_defaults['panel_title'],
                        ]),
                        constalt_acf_field('contacts_page_panel_description', 'Опис форми', 'panel_description', 'textarea', [
                            'default_value' => $contacts_defaults['panel_description'],
                            'rows' => 2,
                        ]),
                        constalt_acf_field('contacts_page_form_service', 'Приховане значення service', 'form_service', 'text', [
                            'default_value' => $contacts_defaults['form_service'],
                        ]),
                        constalt_acf_field('contacts_page_name_placeholder', 'Підказка для імені', 'name_placeholder', 'text', [
                            'default_value' => $contacts_defaults['name_placeholder'],
                        ]),
                        constalt_acf_field('contacts_page_phone_placeholder', 'Підказка для телефону', 'phone_placeholder', 'text', [
                            'default_value' => $contacts_defaults['phone_placeholder'],
                        ]),
                        constalt_acf_field('contacts_page_question_placeholder', 'Підказка для запитання', 'question_placeholder', 'text', [
                            'default_value' => $contacts_defaults['question_placeholder'],
                        ]),
                        constalt_acf_field('contacts_page_consent_label', 'Текст згоди', 'consent_label', 'text', [
                            'default_value' => $contacts_defaults['consent_label'],
                        ]),
                        constalt_acf_field('contacts_page_submit_label', 'Текст кнопки', 'submit_label', 'text', [
                            'default_value' => $contacts_defaults['submit_label'],
                        ]),
                    ]
                ),
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'constalt-contacts-content',
                    ],
                ],
            ],
            'style' => 'seamless',
            'position' => 'normal',
            'instruction_placement' => 'field',
            'active' => true,
        ]
    );
}
add_action('acf/init', 'constalt_register_site_content_field_groups');
