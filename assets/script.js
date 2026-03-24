(function () {

  function init(scope) {

    if (typeof gsap === "undefined") return;

    const container = scope.querySelector('.services');
    if (!container) return;

    const items = container.querySelectorAll('.service-item');

    gsap.registerPlugin(ScrollTrigger);

    gsap.from(items, {
      yPercent: 50,
      opacity: 0,
      stagger: 0.2,
      ease: "power3.out",
      scrollTrigger: {
        trigger: scope,
        start: 'top 40%',
        end: () => "+=" + container.scrollWidth,
        scrub: true,
        pin: true,
        invalidateOnRefresh: true,
      }
    });
  }

  // Frontend
  window.addEventListener("load", function () {
    document.querySelectorAll('.ak-services-wrapper').forEach(init);
  });

  // Elementor Editor Support
  if (window.elementorFrontend) {
    elementorFrontend.hooks.addAction(
      'frontend/element_ready/global',
      function ($scope) {
        const el = $scope[0].querySelector('.ak-services-wrapper');
        if (el) init(el);
      }
    );
  }

})();