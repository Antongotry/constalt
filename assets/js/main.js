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

    window.__constaltLenis = lenis;
    window.requestAnimationFrame(raf);
  }

  function initServicesTabs() {
    var section = document.querySelector('.services-section[data-services-scroll]');

    if (!section) {
      return;
    }

    var tabs = section.querySelectorAll('[data-service-tab]');
    var panels = section.querySelectorAll('[data-service-panel]');
    var pin = section.querySelector('[data-services-pin]');
    var viewport = section.querySelector('[data-services-viewport]');
    var rail = section.querySelector('[data-services-rail]');
    var mediaQuery = window.matchMedia('(min-width: 768px)');
    var state = {
      isDesktop: false,
      currentIndex: 0,
      maxTravel: 0,
      scrollDistance: 0
    };

    if (!tabs.length || !panels.length || !pin || !viewport || !rail) {
      return;
    }

    function clamp(value, min, max) {
      return Math.max(min, Math.min(max, value));
    }

    function activateTab(index) {
      tabs.forEach(function (tab) {
        var tabIndex = parseInt(tab.getAttribute('data-service-tab'), 10) - 1;
        var isActive = tabIndex === index;
        tab.classList.toggle('services-tabs__item--active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });

      state.currentIndex = index;

      if (state.isDesktop) {
        panels.forEach(function (panel) {
          panel.classList.add('is-active');
          panel.hidden = false;
        });
        return;
      }

      panels.forEach(function (panel) {
        var panelIndex = parseInt(panel.getAttribute('data-service-panel'), 10) - 1;
        var isActive = panelIndex === index;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = !isActive;
      });
    }

    function updateDesktopMeasurements() {
      state.maxTravel = Math.max(rail.scrollWidth - viewport.clientWidth, 0);
      state.scrollDistance = state.maxTravel;
      section.style.setProperty('--services-scroll-distance', state.scrollDistance + 'px');
    }

    function updateFromScroll() {
      if (!state.isDesktop) {
        return;
      }

      var sectionTop = section.offsetTop;
      var rawOffset = window.scrollY - sectionTop;
      var progress = state.scrollDistance > 0 ? clamp(rawOffset / state.scrollDistance, 0, 1) : 0;
      var x = state.maxTravel * progress;
      var targetIndex = Math.round(progress * (panels.length - 1));

      rail.style.transform = 'translate3d(' + (-x) + 'px, 0, 0)';

      if (targetIndex !== state.currentIndex) {
        activateTab(targetIndex);
      }
    }

    function setMode() {
      state.isDesktop = mediaQuery.matches;

      if (state.isDesktop) {
        section.classList.add('services-section--horizontal');
        updateDesktopMeasurements();
        activateTab(state.currentIndex);
        updateFromScroll();
        return;
      }

      section.classList.remove('services-section--horizontal');
      section.style.removeProperty('--services-scroll-distance');
      rail.style.transform = '';
      activateTab(state.currentIndex);
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var tabIndex = parseInt(tab.getAttribute('data-service-tab'), 10) - 1;

        if (state.isDesktop) {
          var progress = panels.length > 1 ? tabIndex / (panels.length - 1) : 0;
          var targetY = section.offsetTop + (state.scrollDistance * progress);

          if (window.__constaltLenis && typeof window.__constaltLenis.scrollTo === 'function') {
            window.__constaltLenis.scrollTo(targetY, { duration: 1.05 });
          } else {
            window.scrollTo({ top: targetY, behavior: 'smooth' });
          }
          return;
        }

        activateTab(tabIndex);
      });
    });

    setMode();
    window.addEventListener('scroll', updateFromScroll, { passive: true });
    window.addEventListener('resize', function () {
      setMode();
      updateFromScroll();
    });

    if (typeof mediaQuery.addEventListener === 'function') {
      mediaQuery.addEventListener('change', setMode);
    }
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

  initLenis();
  initServicesTabs();
  initTrustTimeline();
})();
