(function () {
  const toggle = document.querySelector('.site-nav__toggle');
  const nav = document.querySelector('#primary-navigation');

  if (!toggle || !nav) return;

  toggle.addEventListener('click', function () {
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isOpen));
    nav.classList.toggle('is-open', !isOpen);
    document.body.classList.toggle('nav-is-open', !isOpen);
  });

  nav.addEventListener('click', function (event) {
    if (event.target.closest('a')) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      document.body.classList.remove('nav-is-open');
    }
  });
})();
