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

  initLenis();
  initServicesTabs();
})();
