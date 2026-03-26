/* Theme scripts entry point. */
(function () {
  var UA_PHONE_PREFIX = '380';
  var UA_PHONE_LOCAL_DIGITS = 9;

  function getPhoneDigits(value) {
    return String(value || '').replace(/\D/g, '');
  }

  function normalizeToUaPhone(value) {
    var digits = getPhoneDigits(value);
    var localDigits = '';

    if (digits.indexOf(UA_PHONE_PREFIX) === 0) {
      localDigits = digits.slice(UA_PHONE_PREFIX.length, UA_PHONE_PREFIX.length + UA_PHONE_LOCAL_DIGITS);
    } else if (digits.indexOf('0') === 0) {
      localDigits = digits.slice(1, 1 + UA_PHONE_LOCAL_DIGITS);
    } else {
      localDigits = digits.slice(0, UA_PHONE_LOCAL_DIGITS);
    }

    return '+' + UA_PHONE_PREFIX + localDigits;
  }

  function getPhoneValidationMessage(value) {
    var rawValue = String(value || '').trim();
    var digits = getPhoneDigits(rawValue);

    if (!rawValue || rawValue === '+' + UA_PHONE_PREFIX) {
      return 'Вкажіть номер телефону.';
    }

    if (!/^\+?\d+$/.test(rawValue)) {
      return 'Вводьте лише цифри у форматі +380XXXXXXXXX.';
    }

    if ((rawValue.match(/\+/g) || []).length > 1 || (rawValue.indexOf('+') > 0)) {
      return 'Символ "+" можна використовувати лише на початку номера.';
    }

    if (digits.indexOf(UA_PHONE_PREFIX) !== 0 || digits.length !== UA_PHONE_PREFIX.length + UA_PHONE_LOCAL_DIGITS) {
      return 'Введіть номер у форматі +380XXXXXXXXX.';
    }

    return '';
  }

  function validatePhoneInputField(input, shouldReport) {
    if (!input) {
      return true;
    }

    var message = getPhoneValidationMessage(input.value);
    input.setCustomValidity(message);

    if (message && shouldReport) {
      input.reportValidity();
    }

    return message === '';
  }

  function initPhoneFieldValidation() {
    document.querySelectorAll('input[type="tel"]').forEach(function (input) {
      var initialRawValue = String(input.value || '').trim();

      input.value = initialRawValue ? normalizeToUaPhone(initialRawValue) : '';
      input.setAttribute('inputmode', 'tel');
      input.setAttribute('autocomplete', 'tel');
      input.setAttribute('required', 'required');
      input.setAttribute('minlength', '13');
      input.setAttribute('maxlength', '13');
      input.setAttribute('pattern', '^\\+380[0-9]{9}$');

      input.addEventListener('focus', function () {
        if (!input.value) {
          input.value = '+' + UA_PHONE_PREFIX;
        }
      });

      input.addEventListener('keydown', function (event) {
        var start = input.selectionStart || 0;
        var end = input.selectionEnd || 0;

        if ((event.key === 'Backspace' && start <= 4 && end <= 4) || (event.key === 'Delete' && start < 4 && end <= 4)) {
          event.preventDefault();
        }
      });

      input.addEventListener('input', function () {
        input.value = normalizeToUaPhone(input.value);
        input.setCustomValidity('');
      });

      input.addEventListener('blur', function () {
        if (input.value === '+' + UA_PHONE_PREFIX) {
          input.value = '';
        }
      });
    });
  }

  function initLenis() {
    if (typeof window.Lenis !== 'function') {
      return;
    }

    if (window.innerWidth <= 1024) {
      return;
    }

    var lenis = new window.Lenis({
      duration: 1.1,
      smoothWheel: true,
      smoothTouch: false,
      wheelMultiplier: 1
    });

    function raf(time) {
      lenis.raf(time);
      window.requestAnimationFrame(raf);
    }

    if (typeof lenis.on === 'function' && window.ScrollTrigger && typeof window.ScrollTrigger.update === 'function') {
      lenis.on('scroll', window.ScrollTrigger.update);
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (event) {
        var href = anchor.getAttribute('href');

        if (!href || href === '#') {
          return;
        }

        var target = document.querySelector(href);

        if (!target) {
          return;
        }

        event.preventDefault();
        lenis.scrollTo(target, { offset: -88 });
      });
    });

    window.requestAnimationFrame(raf);
  }

  function initHeroVideo() {
    var heroVideo = document.querySelector('.hero__media-video');

    if (!heroVideo) {
      return;
    }

    heroVideo.muted = true;
    heroVideo.defaultMuted = true;
    heroVideo.playsInline = true;
    heroVideo.setAttribute('muted', '');
    heroVideo.setAttribute('playsinline', '');
    heroVideo.setAttribute('webkit-playsinline', '');
    heroVideo.setAttribute('autoplay', '');

    function tryPlay() {
      var playResult = heroVideo.play();

      if (playResult && typeof playResult.catch === 'function') {
        playResult.catch(function () {});
      }
    }

    if (heroVideo.readyState >= 2) {
      tryPlay();
    } else {
      heroVideo.addEventListener('loadeddata', tryPlay, { once: true });
    }

    document.addEventListener('touchstart', tryPlay, { once: true, passive: true });
    document.addEventListener('click', tryPlay, { once: true });
  }

  function initServicesTabs() {
    var section = document.querySelector('.services-section');

    if (!section) {
      return;
    }

    var tabs = section.querySelectorAll('[data-service-tab]');
    var panels = section.querySelectorAll('[data-service-panel]');
    var swiperRoot = section.querySelector('.services-swiper--stack');
    var swiperInstance = null;
    var servicesScrollTrigger = null;
    var servicesPopup = document.querySelector('[data-services-popup]');
    var popupTitle = servicesPopup ? servicesPopup.querySelector('[data-services-popup-title]') : null;
    var popupSubtitle = servicesPopup ? servicesPopup.querySelector('[data-services-popup-subtitle]') : null;
    var popupServiceInput = servicesPopup ? servicesPopup.querySelector('[data-services-popup-service]') : null;
    var popupWideField = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-field]') : null;
    var popupWideInput = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-input]') : null;
    var popupWideLabelScreen = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-label-screen]') : null;
    var popupDetails = servicesPopup ? servicesPopup.querySelector('[data-services-popup-details]') : null;
    var popupConsent = servicesPopup ? servicesPopup.querySelector('[data-services-popup-consent]') : null;
    var popupPostscript = servicesPopup ? servicesPopup.querySelector('[data-services-popup-postscript]') : null;
    var popupSubmitLabel = servicesPopup ? servicesPopup.querySelector('[data-services-popup-submit-label]') : null;
    var popupSubmitButton = servicesPopup ? servicesPopup.querySelector('.services-popup__submit') : null;
    var lastPopupTrigger = null;
    var popupCloseTimer = null;

    if (!tabs.length || !panels.length) {
      return;
    }

    function activateTab(id) {
      if (section.classList.contains('services-section--stack-mobile') || section.classList.contains('services-section--stack-desktop')) {
        return;
      }

      tabs.forEach(function (tab) {
        var isActive = tab.getAttribute('data-service-tab') === id;
        tab.classList.toggle('services-tabs__item--active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });

      panels.forEach(function (panel) {
        var isActive = panel.getAttribute('data-service-panel') === id;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = swiperInstance ? false : !isActive;
      });
    }

    function normalizeText(value) {
      if (!value) {
        return '';
      }

      return value.replace(/\s+/g, ' ').trim();
    }

    function htmlToText(html) {
      var temp = document.createElement('div');
      temp.innerHTML = html;
      return normalizeText(temp.textContent || temp.innerText || '');
    }

    // Fixed sizing rule: all popup dimensions are relative to a 1440px desktop base.
    var popupViewportBase = 1440;

    function toViewportWidth(px) {
      return 'calc(' + px + ' / ' + popupViewportBase + ' * 100vw)';
    }

    var popupDefaults = {
      titleHtml: '',
      subtitle: '',
      titleWidth: 620,
      subtitleWidth: 620,
      titleSize: 42,
      titleWeight: 600,
      titleColor: '#051120',
      subtitleSize: 16,
      subtitleColor: '#051120',
      formWidth: 635,
      rowColumns: 'double',
      mode: 'default',
      showContactFields: true,
      showWideField: true,
      hideConsent: false,
      wideLabel: 'Ваша проблема',
      submitLabel: 'Обговорити задачу',
      detailsHtml: '',
      postscriptText: '',
      postscriptWidth: 0,
      serviceValue: '',
      submitPopupKey: ''
    };

    var popupConfigs = {
      'service-finance': {
        titleHtml: 'Фінансовий консалтинг<br>та управління прибутковістю',
        subtitle: 'Для власників, які прагнуть повного контролю над фінансами компанії.',
        titleWidth: 620,
        subtitleWidth: 574,
        wideLabel: 'Ваша проблема',
        submitLabel: 'Обговорити задачу'
      },
      'service-finance-details': {
        titleHtml: 'Фінансовий консалтинг',
        subtitle: 'У більшості бізнесів фінанси виглядають контрольованими — поки не виникає питання: «а скільки ми реально заробляємо?». Бухгалтерія показує минуле. Але рішення в бізнесі потрібно приймати про майбутнє.',
        titleWidth: 264,
        subtitleWidth: 820,
        titleSize: 24,
        titleWeight: 600,
        subtitleSize: 16,
        formWidth: 820,
        rowColumns: 'details',
        mode: 'details',
        showWideField: false,
        hideConsent: true,
        submitLabel: 'Обговорити фінансову ситуацію',
        submitPopupKey: 'service-finance',
        serviceValue: 'Фінансовий консалтинг',
        detailsHtml: [
          '<div class="services-popup__details-box">',
          '<p class="services-popup__details-box-label">З якими запитами приходять:</p>',
          '<ul class="services-popup__details-list services-popup__details-list--plain">',
          '<li>«Я не розумію реальну прибутковість бізнесу або окремих напрямків»</li>',
          '<li>«Гроші є, але їх постійно не вистачає»</li>',
          '<li>«Я не можу спрогнозувати фінансовий стан на кілька місяців вперед»</li>',
          '<li>«Витрати ростуть швидше за дохід, але незрозуміло чому»</li>',
          '<li>«Потрібно підготувати бізнес до інвестора, партнера або масштабування»</li>',
          '</ul>',
          '</div>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Що насправді змінюється в роботі бізнесу</h4>',
          '<p class="services-popup__details-text">Ми переводимо фінанси з рівня “облік” у рівень “управління”:</p>',
          '<ul class="services-popup__details-list">',
          '<li>ви бачите, які рішення реально впливають на прибуток</li>',
          '<li>з’являється прозора логіка руху грошей</li>',
          '<li>стає зрозуміло, де бізнес втрачає маржу</li>',
          '<li>зникає залежність від «відчуттів»</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<div class="services-popup__details-box services-popup__details-box--dark">',
          '<p class="services-popup__details-box-label services-popup__details-box-label--light">Що отримує клієнт:</p>',
          '<ul class="services-popup__details-list">',
          '<li>структуровану фінансову модель бізнесу</li>',
          '<li>управлінську звітність (P&amp;L, Cash Flow, Balance), яка використовується для рішень</li>',
          '<li>розуміння реальної прибутковості і слабких місць</li>',
          '<li>фінансовий план дій і сценарії розвитку</li>',
          '<li>контроль і передбачуваність</li>',
          '</ul>',
          '</div>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Що важливо врахувати:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>це не разова послуга, а процес зміни підходу</li>',
          '<li>без участі власника ефект буде обмежений</li>',
          '<li>перший результат — не “покращення”, а чесна картина</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>'
        ].join('')
      },
      'service-corporate': {
        titleHtml: 'Корпоративне управління',
        subtitle: 'Для тих, хто переріс ручний контроль і прагне побудувати автономну систему.',
        titleWidth: 620,
        subtitleWidth: 616,
        wideLabel: 'Ваша проблема',
        submitLabel: 'Обговорити задачу'
      },
      'service-corporate-details': {
        titleHtml: 'Корпоративне управління',
        subtitle: 'На певному етапі бізнес перестає масштабуватись не через ринок — а через те, що вся система управління тримається на власнику. Це не проблема людей. Це проблема відсутності структури.',
        titleWidth: 291,
        subtitleWidth: 820,
        titleSize: 24,
        titleWeight: 600,
        subtitleSize: 16,
        formWidth: 820,
        rowColumns: 'details',
        mode: 'details',
        showContactFields: false,
        showWideField: false,
        hideConsent: true,
        submitLabel: 'Обговорити структуру управління',
        submitPopupKey: 'service-corporate',
        postscriptText: 'Подивимось, де саме бізнес залежить від вас і які є варіанти змін.',
        postscriptWidth: 485,
        serviceValue: 'Корпоративне управління',
        detailsHtml: [
          '<div class="services-popup__details-box">',
          '<p class="services-popup__details-box-label">З якими запитами приходять:</p>',
          '<ul class="services-popup__details-list services-popup__details-list--plain">',
          '<li>«Я залучений у всі ключові рішення і не можу вийти з операційки»</li>',
          '<li>«Команда є, але відповідальність розмита»</li>',
          '<li>«Партнери починають впливати на бізнес хаотично»</li>',
          '<li>«Я не розумію, як контролювати бізнес без постійної участі»</li>',
          '<li>«Інвестори задають питання, на які у мене немає системної відповіді»</li>',
          '</ul>',
          '</div>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Що насправді відбувається<br>Без системи управління:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>бізнес залежить від однієї людини</li>',
          '<li>рішення приймаються ситуативно</li>',
          '<li>зростають конфлікти і ризики</li>',
          '<li>масштабування стає неконтрольованим</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Що змінюється після роботи:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>структуру корпоративного управління</li>',
          '<li>розподіл ролей (власник / менеджмент / партнери)</li>',
          '<li>правила прийняття рішень і систему контролю</li>',
          '<li>зниження управлінських і партнерських ризиків</li>',
          '<li>основу для масштабування або інвестицій</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-box services-popup__details-box--dark">',
          '<p class="services-popup__details-box-label services-popup__details-box-label--light">Що отримує клієнт:</p>',
          '<ul class="services-popup__details-list">',
          '<li>структуру корпоративного управління</li>',
          '<li>розподіл ролей (власник / менеджмент / партнери)</li>',
          '<li>правила прийняття рішень і систему контролю</li>',
          '<li>зниження управлінських і партнерських ризиків</li>',
          '<li>основу для масштабування або інвестицій</li>',
          '</ul>',
          '</div>'
        ].join('')
      },
      'service-due-diligence': {
        titleHtml: 'Due Diligence та<br><strong>інвестиційний супровід</strong>',
        subtitle: 'Підготовка до залучення капіталу, продажу частки або входу в нове партнерство.',
        titleWidth: 579,
        subtitleWidth: 620,
        titleWeight: 300,
        wideLabel: 'Ваше запитання',
        submitLabel: 'Обговорити задачу'
      },
      'service-due-diligence-details': {
        titleHtml: 'Due Diligence та інвестиційний супровід',
        subtitle: 'Більшість ризиків в угодах виникають не через складність — а через неповну інформацію на момент прийняття рішення.',
        titleWidth: 446,
        subtitleWidth: 820,
        titleSize: 24,
        titleWeight: 600,
        subtitleSize: 16,
        formWidth: 820,
        rowColumns: 'details',
        mode: 'details',
        showContactFields: false,
        showWideField: false,
        hideConsent: true,
        submitLabel: 'Обговорити запит',
        submitPopupKey: 'service-due-diligence',
        postscriptText: 'Оцінимо ризики і скажемо, на що варто звернути увагу до прийняття рішення.',
        postscriptWidth: 577,
        serviceValue: 'Due Diligence та інвестиційний супровід',
        detailsHtml: [
          '<div class="services-popup__details-box">',
          '<p class="services-popup__details-box-label">З якими запитами приходять:</p>',
          '<ul class="services-popup__details-list services-popup__details-list--plain">',
          '<li>«Я хочу зрозуміти реальний стан бізнесу перед угодою»</li>',
          '<li>«Не хочу ризиків, які проявляться після підписання»</li>',
          '<li>«Потрібно підготуватись до переговорів і посилити позицію»</li>',
          '<li>«Хочу зрозуміти, що може вплинути на вартість бізнесу»</li>',
          '</ul>',
          '</div>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading services-popup__details-heading--narrow">Ми не просто перевіряємо бізнес — ми показуємо, де саме знаходяться ризики і як вони впливають на рішення:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>фінансові викривлення і реальна прибутковість</li>',
          '<li>юридичні ризики і зобов’язання</li>',
          '<li>слабкі місця структури бізнесу</li>',
          '<li>фактори, які можуть вплинути на угоду</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<div class="services-popup__details-box services-popup__details-box--dark">',
          '<p class="services-popup__details-box-label services-popup__details-box-label--light">Що отримує клієнт:</p>',
          '<ul class="services-popup__details-list">',
          '<li>структурований фінансовий і юридичний аналіз</li>',
          '<li>карту ризиків із пріоритетами</li>',
          '<li>рекомендації щодо структури угоди</li>',
          '<li>аргументи для переговорів</li>',
          '<li>впевненість у прийнятті рішення</li>',
          '</ul>',
          '</div>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Що важливо:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>due diligence не гарантує результат угоди</li>',
          '<li>але він дає розуміння, за що саме ви платите або що продаєте</li>',
          '<li>іноді ключовий результат — рішення НЕ входити в угоду</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>',
          '<section class="services-popup__details-section">',
          '<h4 class="services-popup__details-heading">Коли це не має сенсу:</h4>',
          '<ul class="services-popup__details-list">',
          '<li>якщо рішення вже прийняте і аналіз формальний</li>',
          '<li>якщо немає часу на якісну перевірку</li>',
          '<li>якщо клієнт не готовий чути ризики</li>',
          '</ul>',
          '</section>',
          '<div class="services-popup__details-divider" aria-hidden="true"></div>'
        ].join('')
      },
      'service-legal': {
        titleHtml: 'Юридична архітектура та захист активів',
        subtitle: 'Створення надійного фундаменту та оперативний захист інтересів власника.',
        titleWidth: 498,
        subtitleWidth: 620,
        wideLabel: 'Ваша проблема',
        submitLabel: 'Обговорити задачу'
      },
      'collaboration-expert': {
        titleHtml: 'Експертна консультація',
        subtitle: 'Коли власнику потрібно зрозуміти реальний стан бізнесу та визначити ключові проблеми.',
        titleWidth: 269,
        subtitleWidth: 536,
        titleSize: 24,
        rowColumns: 'single',
        showWideField: false,
        submitLabel: 'Залишити заявку'
      },
      'collaboration-project': {
        titleHtml: 'Проєктна робота',
        subtitle: 'Коли бізнесу потрібно не лише визначити проблему, а й впровадити рішення.',
        titleWidth: 193,
        subtitleWidth: 575,
        titleSize: 24,
        rowColumns: 'single',
        showWideField: false,
        submitLabel: 'Залишити заявку'
      },
      'collaboration-strategic': {
        titleHtml: 'Стратегічний супровід',
        subtitle: 'Коли власнику потрібен партнер для складних управлінських рішень і розвитку бізнесу.',
        titleWidth: 255,
        subtitleWidth: 518,
        titleSize: 24,
        rowColumns: 'single',
        showWideField: false,
        submitLabel: 'Залишити заявку'
      },
      'consultation-general': {
        titleHtml: 'Бажаєте отримати консультацію?',
        subtitle: 'Якщо у вас є питання щодо фінансів, структури управління чи розвитку компанії — обговоримо ситуацію та можливі рішення.',
        titleWidth: 502,
        subtitleWidth: 502,
        titleSize: 42,
        subtitleSize: 16,
        titleWeight: 300,
        titleColor: '#192432',
        subtitleColor: '#192432',
        formWidth: 635,
        rowColumns: 'double',
        showWideField: true,
        wideLabel: 'Ваше запитання',
        submitLabel: 'Залишити заявку',
        serviceValue: 'Загальна консультація'
      }
    };

    function resolvePopupConfig(key) {
      var source = popupConfigs[key];

      if (!source) {
        return null;
      }

      var resolved = {};

      Object.keys(popupDefaults).forEach(function (prop) {
        resolved[prop] = popupDefaults[prop];
      });

      Object.keys(source).forEach(function (prop) {
        resolved[prop] = source[prop];
      });

      return resolved;
    }

    function applyPopupConfig(config) {
      if (!servicesPopup || !popupTitle || !popupSubtitle) {
        return;
      }

      popupTitle.innerHTML = config.titleHtml;
      popupSubtitle.textContent = config.subtitle;

      if (popupSubmitLabel) {
        popupSubmitLabel.textContent = config.submitLabel;
      }

      if (popupSubmitButton) {
        var hasSubmitPopupKey = !!config.submitPopupKey;

        popupSubmitButton.type = hasSubmitPopupKey ? 'button' : 'submit';

        if (hasSubmitPopupKey) {
          popupSubmitButton.setAttribute('data-site-popup-open', '');
          popupSubmitButton.setAttribute('data-popup-key', config.submitPopupKey);
        } else {
          popupSubmitButton.removeAttribute('data-site-popup-open');
          popupSubmitButton.removeAttribute('data-popup-key');
        }
      }

      if (popupWideInput) {
        popupWideInput.placeholder = config.wideLabel;
      }

      if (popupWideLabelScreen) {
        popupWideLabelScreen.textContent = config.wideLabel;
      }

      if (popupDetails) {
        popupDetails.innerHTML = config.detailsHtml || '';
        popupDetails.hidden = !config.detailsHtml;
      }

      if (popupPostscript) {
        popupPostscript.textContent = config.postscriptText || '';
        popupPostscript.hidden = !config.postscriptText;
      }

      servicesPopup.classList.toggle('services-popup--without-wide-field', !config.showWideField);
      servicesPopup.classList.toggle('services-popup--without-contact-fields', !config.showContactFields);
      servicesPopup.classList.toggle('services-popup--without-consent', !!config.hideConsent);
      servicesPopup.classList.toggle('services-popup--details-mode', config.mode === 'details');

      if (popupConsent) {
        popupConsent.hidden = !!config.hideConsent;
      }

      servicesPopup.style.setProperty('--popup-title-width', toViewportWidth(config.titleWidth));
      servicesPopup.style.setProperty('--popup-subtitle-width', toViewportWidth(config.subtitleWidth));
      servicesPopup.style.setProperty('--popup-title-size', toViewportWidth(config.titleSize));
      servicesPopup.style.setProperty('--popup-subtitle-size', toViewportWidth(config.subtitleSize));
      servicesPopup.style.setProperty('--popup-title-weight', String(config.titleWeight));
      servicesPopup.style.setProperty('--popup-title-color', config.titleColor);
      servicesPopup.style.setProperty('--popup-subtitle-color', config.subtitleColor);
      servicesPopup.style.setProperty('--popup-form-width', toViewportWidth(config.formWidth));
      servicesPopup.style.setProperty('--popup-submit-width', toViewportWidth(config.formWidth));
      servicesPopup.style.setProperty(
        '--popup-postscript-width',
        toViewportWidth(config.postscriptWidth || config.subtitleWidth || config.formWidth)
      );
      servicesPopup.style.setProperty(
        '--popup-row-columns',
        config.rowColumns === 'single'
          ? '1fr'
          : config.rowColumns === 'details'
            ? toViewportWidth(396) + ' ' + toViewportWidth(396)
            : toViewportWidth(305) + ' ' + toViewportWidth(305)
      );

      if (popupServiceInput) {
        popupServiceInput.value = config.serviceValue || htmlToText(config.titleHtml);
      }
    }

    function closeServicesPopup(restoreFocus) {
      if (!servicesPopup || servicesPopup.hidden) {
        return;
      }

      if (popupCloseTimer) {
        window.clearTimeout(popupCloseTimer);
      }

      servicesPopup.classList.remove('is-visible');
      document.body.classList.remove('services-popup-open');
      document.body.style.overflow = '';

      popupCloseTimer = window.setTimeout(function () {
        servicesPopup.hidden = true;
        popupCloseTimer = null;
      }, 360);

      if (restoreFocus !== false && lastPopupTrigger && typeof lastPopupTrigger.focus === 'function') {
        lastPopupTrigger.focus();
      }
    }

    function openServicesPopup(config, trigger) {
      if (!servicesPopup || !config) {
        return;
      }

      applyPopupConfig(config);

      if (popupCloseTimer) {
        window.clearTimeout(popupCloseTimer);
        popupCloseTimer = null;
      }

      lastPopupTrigger = trigger || null;
      servicesPopup.hidden = false;
      window.requestAnimationFrame(function () {
        servicesPopup.classList.add('is-visible');
      });
      document.body.classList.add('services-popup-open');
      document.body.style.overflow = 'hidden';
    }

    function initServicesPopup() {
      if (!servicesPopup) {
        return;
      }

      document.addEventListener('click', function (event) {
        var openButton = event.target.closest('[data-site-popup-open]');

        if (!openButton) {
          return;
        }

        var popupKey = openButton.getAttribute('data-popup-key');
        var popupConfig = resolvePopupConfig(popupKey);

        if (!popupConfig) {
          return;
        }

        event.preventDefault();

        openServicesPopup(popupConfig, openButton);
      });

      servicesPopup.addEventListener('click', function (event) {
        var closeTrigger = event.target.closest('[data-services-popup-close]');

        if (closeTrigger) {
          closeServicesPopup();
        }
      });

      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !servicesPopup.hidden) {
          closeServicesPopup();
        }
      });
    }

    initServicesPopup();

    if (swiperRoot) {
      function isDesktopViewport() {
        return window.innerWidth > 1024;
      }

      function destroyServicesScrollTrigger() {
        if (!servicesScrollTrigger) {
          return;
        }

        var spacer = section.parentElement;
        if (spacer && spacer.classList.contains('pin-spacer')) {
          spacer.style.zIndex = '';
        }

        servicesScrollTrigger.kill();
        servicesScrollTrigger = null;
        section.classList.remove('services-section--scroll-locked');
      }

      function resetSwiperDomState() {
        swiperRoot.classList.remove('swiper-initialized', 'swiper-horizontal', 'swiper-backface-hidden');
        swiperRoot.removeAttribute('style');

        var wrappers = swiperRoot.querySelectorAll('.services-swiper__wrapper');
        wrappers.forEach(function (wrapper) {
          wrapper.removeAttribute('style');
        });

        swiperRoot.querySelectorAll('.services-swiper__slide').forEach(function (slide) {
          slide.removeAttribute('style');
        });
      }

      function applyStackLayout(isDesktop) {
        destroyServicesScrollTrigger();

        if (swiperInstance) {
          swiperInstance.destroy(true, true);
          swiperInstance = null;
        }

        resetSwiperDomState();

        section.classList.remove('services-section--swiper-ready');
        section.classList.remove('services-section--scroll-locked');
        section.classList.toggle('services-section--stack-desktop', isDesktop);
        section.classList.toggle('services-section--stack-mobile', !isDesktop);

        panels.forEach(function (panel) {
          panel.hidden = false;
          panel.classList.add('is-active');
        });

        tabs.forEach(function (tab) {
          tab.setAttribute('aria-hidden', 'true');
          tab.setAttribute('tabindex', '-1');
        });
      }

      function syncServicesLayout() {
        applyStackLayout(isDesktopViewport());
      }

      syncServicesLayout();

      window.addEventListener('resize', function () {
        syncServicesLayout();
      });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        if (window.innerWidth <= 1024 || section.classList.contains('services-section--stack-desktop') || section.classList.contains('services-section--stack-mobile')) {
          return;
        }

        var id = tab.getAttribute('data-service-tab');
        var index = Number(id) - 1;

        if (swiperInstance) {
          swiperInstance.slideTo(index);
        }

        activateTab(id);
      });
    });
  }

  function initTrustTimeline() {
    var section = document.querySelector('[data-trust-section]');

    if (!section) {
      return;
    }

    var timeline = section.querySelector('[data-trust-timeline]');
    var track = section.querySelector('[data-trust-track]');
    var fill = section.querySelector('[data-trust-fill]');
    var steps = section.querySelectorAll('[data-trust-step]');

    if (!timeline || !track || !fill || !steps.length) {
      return;
    }

    function clamp(value, min, max) {
      return Math.max(min, Math.min(max, value));
    }

    function updateTimeline() {
      var trackRect = track.getBoundingClientRect();
      var anchorY = window.innerHeight * 0.45;
      var progress = clamp(anchorY - trackRect.top, 0, trackRect.height);

      fill.style.height = progress + 'px';

      steps.forEach(function (step) {
        var iconBox = step.querySelector('[data-trust-icon-box]');
        var icon = step.querySelector('[data-trust-icon]');

        if (!iconBox || !icon) {
          return;
        }

        var stepRect = step.getBoundingClientRect();
        var stepCenterOnTrack = (stepRect.top + stepRect.height * 0.5) - trackRect.top;
        var isActive = progress >= stepCenterOnTrack;
        var activeSrc = icon.getAttribute('data-icon-active');
        var inactiveSrc = icon.getAttribute('data-icon-inactive');

        iconBox.classList.toggle('is-active', isActive);

        if (isActive && activeSrc && icon.getAttribute('src') !== activeSrc) {
          icon.setAttribute('src', activeSrc);
        }

        if (!isActive && inactiveSrc && icon.getAttribute('src') !== inactiveSrc) {
          icon.setAttribute('src', inactiveSrc);
        }
      });
    }

    updateTimeline();
    window.addEventListener('scroll', updateTimeline, { passive: true });
    window.addEventListener('resize', updateTimeline);
  }

  function initFaqAccordion() {
    var faqSection = document.querySelector('[data-faq-grid]');

    if (!faqSection) {
      return;
    }

    var items = faqSection.querySelectorAll('[data-faq-item]');

    if (!items.length) {
      return;
    }

    function openItem(item) {
      var trigger = item.querySelector('[data-faq-trigger]');
      var content = item.querySelector('[data-faq-content]');

      if (!trigger || !content) {
        return;
      }

      item.classList.add('is-open');
      trigger.setAttribute('aria-expanded', 'true');
      content.setAttribute('aria-hidden', 'false');

      content.style.height = content.scrollHeight + 'px';
    }

    function closeItem(item) {
      var trigger = item.querySelector('[data-faq-trigger]');
      var content = item.querySelector('[data-faq-content]');

      if (!trigger || !content) {
        return;
      }

      if (item.classList.contains('is-open')) {
        content.style.height = content.scrollHeight + 'px';
      }

      item.classList.remove('is-open');
      trigger.setAttribute('aria-expanded', 'false');
      content.setAttribute('aria-hidden', 'true');

      window.requestAnimationFrame(function () {
        content.style.height = '0px';
      });
    }

    items.forEach(function (item) {
      var trigger = item.querySelector('[data-faq-trigger]');
      var content = item.querySelector('[data-faq-content]');

      if (!trigger || !content) {
        return;
      }

      content.style.height = '0px';

      trigger.addEventListener('click', function () {
        var isOpen = item.classList.contains('is-open');

        items.forEach(function (otherItem) {
          if (otherItem !== item) {
            closeItem(otherItem);
          }
        });

        if (isOpen) {
          closeItem(item);
        } else {
          openItem(item);
        }
      });

      content.addEventListener('transitionend', function (event) {
        if (event.propertyName !== 'height') {
          return;
        }

        if (item.classList.contains('is-open')) {
          content.style.height = 'auto';
        }
      });
    });

    window.addEventListener('resize', function () {
      items.forEach(function (item) {
        if (!item.classList.contains('is-open')) {
          return;
        }

        var content = item.querySelector('[data-faq-content]');

        if (!content) {
          return;
        }

        content.style.height = 'auto';
      });
    });
  }

  function initHeaderMenu() {
    var header = document.querySelector('.site-header');

    if (!header) {
      return;
    }

    var toggle = header.querySelector('[data-header-menu-toggle]');
    var mobileMenu = header.querySelector('[data-header-mobile-menu]');
    var closeTriggers = header.querySelectorAll('[data-header-menu-close], [data-header-menu-link]');

    if (!toggle || !mobileMenu) {
      return;
    }

    function syncBodyScroll() {
      var popupOpen = document.body.classList.contains('services-popup-open');
      var thanksPopupOpen = document.body.classList.contains('site-popup-open');
      var menuOpen = header.classList.contains('site-header--menu-open');
      document.body.style.overflow = popupOpen || thanksPopupOpen || menuOpen ? 'hidden' : '';
    }

    function closeMenu() {
      if (!header.classList.contains('site-header--menu-open')) {
        return;
      }

      header.classList.remove('site-header--menu-open');
      toggle.setAttribute('aria-expanded', 'false');
      mobileMenu.hidden = true;
      syncBodyScroll();
    }

    function openMenu() {
      mobileMenu.hidden = false;
      header.classList.add('site-header--menu-open');
      toggle.setAttribute('aria-expanded', 'true');
      syncBodyScroll();
    }

    toggle.addEventListener('click', function () {
      if (header.classList.contains('site-header--menu-open')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    closeTriggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        closeMenu();
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeMenu();
      }
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 1024) {
        closeMenu();
      }
    });
  }

  function initBlogArchiveFilters() {
    var filtersRoot = document.querySelector('.blog-page__filters');

    if (!filtersRoot) {
      return;
    }

    var filterLinks = filtersRoot.querySelectorAll('[data-blog-filter]');
    var posts = document.querySelectorAll('[data-blog-post]');

    if (!filterLinks.length || !posts.length) {
      return;
    }

    var emptyMessage = document.querySelector('[data-blog-filter-empty]');

    if (!emptyMessage) {
      emptyMessage = document.createElement('p');
      emptyMessage.className = 'blog-section__empty';
      emptyMessage.setAttribute('data-blog-filter-empty', '');
      emptyMessage.textContent = 'За обраною рубрикою записів не знайдено.';
      emptyMessage.hidden = true;

      var archiveLayout = document.querySelector('.blog-layout--archive');

      if (archiveLayout && archiveLayout.parentNode) {
        archiveLayout.parentNode.insertBefore(emptyMessage, archiveLayout.nextSibling);
      }
    }

    function getPostCategories(postNode) {
      var rawValue = String(postNode.getAttribute('data-blog-categories') || '').trim();

      if (!rawValue) {
        return [];
      }

      return rawValue.split(/\s+/);
    }

    function setActiveFilter(slug) {
      filterLinks.forEach(function (link) {
        var isActive = String(link.getAttribute('data-blog-filter') || '') === slug;
        link.classList.toggle('is-active', isActive);

        if (isActive) {
          link.setAttribute('aria-current', 'true');
        } else {
          link.removeAttribute('aria-current');
        }
      });
    }

    function applyFilter(slug) {
      var visibleCount = 0;

      posts.forEach(function (postNode) {
        var postCategories = getPostCategories(postNode);
        var isVisible = !slug || postCategories.indexOf(slug) !== -1;

        postNode.hidden = !isVisible;
        postNode.setAttribute('aria-hidden', isVisible ? 'false' : 'true');

        if (isVisible) {
          visibleCount += 1;
        }
      });

      if (emptyMessage) {
        emptyMessage.hidden = visibleCount !== 0;
      }
    }

    filterLinks.forEach(function (link) {
      link.addEventListener('click', function (event) {
        event.preventDefault();

        var selectedSlug = String(link.getAttribute('data-blog-filter') || '');
        setActiveFilter(selectedSlug);
        applyFilter(selectedSlug);
      });
    });

    var initialActive = filtersRoot.querySelector('.blog-page__filter.is-active[data-blog-filter]');
    var initialSlug = initialActive ? String(initialActive.getAttribute('data-blog-filter') || '') : '';

    setActiveFilter(initialSlug);
    applyFilter(initialSlug);
  }

  function initGlobalThanksPopup() {
    var thanksPopup = document.querySelector('[data-thanks-popup]');

    if (!thanksPopup) {
      return;
    }

    function closeThanksPopup() {
      if (thanksPopup.hidden) {
        return;
      }

      thanksPopup.classList.remove('is-visible');
      document.body.classList.remove('site-popup-open');
      document.body.style.overflow = '';

      window.setTimeout(function () {
        thanksPopup.hidden = true;
      }, 360);
    }

    function openThanksPopup() {
      thanksPopup.hidden = false;
      window.requestAnimationFrame(function () {
        thanksPopup.classList.add('is-visible');
      });
      document.body.classList.remove('services-popup-open');
      document.body.classList.add('site-popup-open');
      document.body.style.overflow = 'hidden';
    }

    function submitFormToServer(form) {
      var config = window.constaltFormConfig || {};

      if (!config.ajaxUrl || !config.nonce) {
        return Promise.reject(new Error('missing-config'));
      }

      var payload = new URLSearchParams();
      var formData = new FormData(form);

      payload.append('action', 'constalt_submit_form');
      payload.append('nonce', config.nonce);

      formData.forEach(function (value, key) {
        payload.append(key, String(value));
      });

      return window.fetch(config.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: payload.toString()
      }).then(function (response) {
        return response.json().catch(function () {
          return {};
        }).then(function (data) {
          if (!response.ok || !data || data.success !== true) {
            throw new Error((data && data.data && data.data.message) || 'submit-failed');
          }

          return data;
        });
      });
    }

    thanksPopup.addEventListener('click', function (event) {
      if (event.target.closest('[data-thanks-popup-close]')) {
        closeThanksPopup();
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !thanksPopup.hidden) {
        closeThanksPopup();
      }
    });

    document.addEventListener('submit', function (event) {
      var submittedForm = event.target.closest('.services-popup__form, .contact-form');

      if (!submittedForm) {
        return;
      }

      var phoneInput = submittedForm.querySelector('input[type="tel"]');

      if (phoneInput && !validatePhoneInputField(phoneInput, true)) {
        event.preventDefault();
        return;
      }

      event.preventDefault();
      var submitButton = submittedForm.querySelector('button[type="submit"]');

      if (submitButton) {
        submitButton.disabled = true;
      }

      submitFormToServer(submittedForm).then(function () {
        submittedForm.reset();

        var servicesPopup = document.querySelector('[data-services-popup]');
        if (servicesPopup && !servicesPopup.hidden) {
          servicesPopup.classList.remove('is-visible');
          servicesPopup.hidden = true;
        }

        openThanksPopup();
      }).catch(function (error) {
        var message = (error && error.message && error.message !== 'submit-failed' && error.message !== 'missing-config')
          ? error.message
          : 'Не вдалося надіслати форму. Спробуйте ще раз.';
        window.alert(message);
      }).finally(function () {
        if (submitButton) {
          submitButton.disabled = false;
        }
      });
    });
  }

  document.addEventListener('input', function (event) {
    var el = event.target;

    if (el && el.matches && el.matches('input[type="tel"]')) {
      el.setCustomValidity('');
    }
  });

  document.addEventListener('blur', function (event) {
    var el = event.target;

    if (el && el.matches && el.matches('input[type="tel"]')) {
      validatePhoneInputField(el, false);
    }
  }, true);

  initPhoneFieldValidation();
  initLenis();
  initHeroVideo();
  initGlobalThanksPopup();
  initServicesTabs();
  initTrustTimeline();
  initFaqAccordion();
  initBlogArchiveFilters();
  initHeaderMenu();
})();
