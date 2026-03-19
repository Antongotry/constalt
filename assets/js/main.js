/* Theme scripts entry point. */
(function () {
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
})();
