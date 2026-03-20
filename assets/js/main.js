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

    window.requestAnimationFrame(raf);
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
    var wheelLockedUntil = 0;

    if (!tabs.length || !panels.length) {
      return;
    }

    function activateTab(id) {
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

    if (swiperRoot && typeof window.Swiper === 'function') {
      panels.forEach(function (panel) {
        panel.hidden = false;
      });

      section.classList.add('services-section--swiper-ready');

      swiperInstance = new window.Swiper(swiperRoot, {
        slidesPerView: 1,
        speed: 700,
        allowTouchMove: true,
        resistanceRatio: 0.72,
        spaceBetween: 0,
        autoHeight: false
      });

      swiperInstance.on('slideChange', function () {
        activateTab(String(swiperInstance.activeIndex + 1));
      });

      function shouldLockWheel() {
        if (window.innerWidth < 768) {
          return false;
        }

        var rect = section.getBoundingClientRect();
        var viewportHeight = window.innerHeight;
        var sectionInFocus = rect.top <= viewportHeight * 0.2 && rect.bottom >= viewportHeight * 0.8;

        return sectionInFocus;
      }

      function onWheel(event) {
        if (!shouldLockWheel() || !swiperInstance) {
          return;
        }

        var now = Date.now();
        if (now < wheelLockedUntil) {
          event.preventDefault();
          return;
        }

        var deltaY = event.deltaY;
        var isForward = deltaY > 0;
        var isBackward = deltaY < 0;
        var atEnd = swiperInstance.activeIndex >= (panels.length - 1);
        var atStart = swiperInstance.activeIndex <= 0;

        if ((isForward && atEnd) || (isBackward && atStart)) {
          return;
        }

        if (Math.abs(deltaY) < 6) {
          return;
        }

        event.preventDefault();

        if (isForward) {
          swiperInstance.slideNext();
        } else if (isBackward) {
          swiperInstance.slidePrev();
        }

        wheelLockedUntil = now + 560;
      }

      window.addEventListener('wheel', onWheel, { passive: false });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
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

  initLenis();
  initServicesTabs();
  initTrustTimeline();
  initFaqAccordion();
})();
