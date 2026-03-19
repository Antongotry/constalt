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
        panel.hidden = !isActive;
      });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        activateTab(tab.getAttribute('data-service-tab'));
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

  initLenis();
  initServicesTabs();
  initTrustTimeline();
})();
