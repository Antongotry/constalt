/* Theme scripts entry point. */
(function () {
  function initLenis() {
    if (typeof window.Lenis !== 'function') {
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
    var swiperRoot = section.querySelector('[data-services-swiper]');
    var swiperInstance = null;
    var servicesScrollTrigger = null;
    var servicesPopup = document.querySelector('[data-services-popup]');
    var popupTitle = servicesPopup ? servicesPopup.querySelector('[data-services-popup-title]') : null;
    var popupSubtitle = servicesPopup ? servicesPopup.querySelector('[data-services-popup-subtitle]') : null;
    var popupServiceInput = servicesPopup ? servicesPopup.querySelector('[data-services-popup-service]') : null;
    var popupWideField = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-field]') : null;
    var popupWideInput = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-input]') : null;
    var popupWideLabelScreen = servicesPopup ? servicesPopup.querySelector('[data-services-popup-wide-label-screen]') : null;
    var popupSubmitLabel = servicesPopup ? servicesPopup.querySelector('[data-services-popup-submit-label]') : null;
    var lastPopupTrigger = null;
    var popupCloseTimer = null;

    if (!tabs.length || !panels.length) {
      return;
    }

    function activateTab(id) {
      if (section.classList.contains('services-section--stack-mobile')) {
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
      showWideField: true,
      wideLabel: 'Ваша проблема',
      submitLabel: 'Обговорити задачу',
      serviceValue: ''
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
      'service-corporate': {
        titleHtml: 'Корпоративне управління',
        subtitle: 'Для тих, хто переріс ручний контроль і прагне побудувати автономну систему.',
        titleWidth: 620,
        subtitleWidth: 616,
        wideLabel: 'Ваша проблема',
        submitLabel: 'Обговорити задачу'
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

      if (popupWideInput) {
        popupWideInput.placeholder = config.wideLabel;
      }

      if (popupWideLabelScreen) {
        popupWideLabelScreen.textContent = config.wideLabel;
      }

      servicesPopup.classList.toggle('services-popup--without-wide-field', !config.showWideField);

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
        '--popup-row-columns',
        config.rowColumns === 'single'
          ? '1fr'
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

    if (swiperRoot && typeof window.Swiper === 'function') {
      function isDesktopViewport() {
        return window.innerWidth > 1024;
      }

      function destroyServicesScrollTrigger() {
        if (!servicesScrollTrigger) {
          return;
        }

        servicesScrollTrigger.kill();
        servicesScrollTrigger = null;
        section.classList.remove('services-section--scroll-locked');
      }

      function setTouchModeByViewport() {
        if (!swiperInstance || !swiperInstance.params) {
          return;
        }

        swiperInstance.params.allowTouchMove = false;
        swiperInstance.allowTouchMove = false;
      }

      function createServicesScrollTrigger() {
        destroyServicesScrollTrigger();
        setTouchModeByViewport();

        if (!isDesktopViewport() || !swiperInstance) {
          return;
        }

        if (!window.gsap || !window.ScrollTrigger) {
          return;
        }

        window.gsap.registerPlugin(window.ScrollTrigger);

        var maxIndex = panels.length - 1;
        var lastSyncedIndex = swiperInstance.activeIndex;

        servicesScrollTrigger = window.ScrollTrigger.create({
          trigger: swiperRoot,
          start: 'bottom bottom',
          end: function () {
            return '+=' + (window.innerHeight * maxIndex);
          },
          pin: section,
          pinSpacing: true,
          scrub: 0.2,
          invalidateOnRefresh: true,
          onToggle: function (self) {
            section.classList.toggle('services-section--scroll-locked', self.isActive);
          },
          onUpdate: function (self) {
            var index = Math.round(self.progress * maxIndex);

            if (index === lastSyncedIndex) {
              return;
            }

            swiperInstance.slideTo(index);
            lastSyncedIndex = index;
          }
        });
      }

      function applyMobileStackLayout() {
        destroyServicesScrollTrigger();

        if (swiperInstance) {
          swiperInstance.destroy(true, true);
          swiperInstance = null;
        }

        section.classList.remove('services-section--swiper-ready');
        section.classList.remove('services-section--scroll-locked');
        section.classList.add('services-section--stack-mobile');

        panels.forEach(function (panel) {
          panel.hidden = false;
          panel.classList.add('is-active');
        });

        tabs.forEach(function (tab) {
          tab.setAttribute('aria-hidden', 'true');
          tab.setAttribute('tabindex', '-1');
        });
      }

      function applyDesktopSwiperLayout() {
        section.classList.remove('services-section--stack-mobile');

        tabs.forEach(function (tab) {
          tab.removeAttribute('aria-hidden');
          tab.removeAttribute('tabindex');
        });

        if (swiperInstance) {
          setTouchModeByViewport();
          createServicesScrollTrigger();
          return;
        }

        panels.forEach(function (panel) {
          panel.hidden = false;
        });

        section.classList.add('services-section--swiper-ready');

        swiperInstance = new window.Swiper(swiperRoot, {
          slidesPerView: 1,
          speed: 500,
          allowTouchMove: false,
          resistanceRatio: 0.72,
          spaceBetween: 0,
          autoHeight: false
        });

        swiperInstance.on('slideChange', function () {
          activateTab(String(swiperInstance.activeIndex + 1));
        });

        activateTab('1');
        createServicesScrollTrigger();
      }

      function syncServicesLayout() {
        if (isDesktopViewport()) {
          applyDesktopSwiperLayout();
        } else {
          applyMobileStackLayout();
        }
      }

      syncServicesLayout();

      window.addEventListener('resize', function () {
        syncServicesLayout();

        if (window.ScrollTrigger && typeof window.ScrollTrigger.refresh === 'function') {
          window.ScrollTrigger.refresh();
        }
      });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        if (window.innerWidth <= 1024) {
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

      event.preventDefault();
      submittedForm.reset();

      var servicesPopup = document.querySelector('[data-services-popup]');
      if (servicesPopup && !servicesPopup.hidden) {
        servicesPopup.classList.remove('is-visible');
        servicesPopup.hidden = true;
      }

      openThanksPopup();
    });
  }

  initLenis();
  initHeroVideo();
  initGlobalThanksPopup();
  initServicesTabs();
  initTrustTimeline();
  initFaqAccordion();
  initHeaderMenu();
})();
