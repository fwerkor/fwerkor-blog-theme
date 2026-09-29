(() => {
  const nav = document.getElementById('site-navigation');
  const menuButton = document.querySelector('.menu-toggle');
  const searchButton = document.querySelector('.search-toggle');
  const searchPanel = document.getElementById('site-search-panel');
  const themeButton = document.querySelector('.theme-toggle');
  const themeMenu = document.getElementById('theme-menu');
  const themeChoices = [...document.querySelectorAll('[data-theme-choice]')];
  const themeColor = document.getElementById('fw-theme-color');
  const media = window.matchMedia('(prefers-color-scheme: dark)');
  const storageKey = 'fwerkor-color-mode';

  if (menuButton && nav) {
    menuButton.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  if (searchButton && searchPanel) {
    searchButton.addEventListener('click', () => {
      const opening = searchPanel.hasAttribute('hidden');
      searchPanel.toggleAttribute('hidden', !opening);
      searchButton.setAttribute('aria-expanded', opening ? 'true' : 'false');
      if (opening) window.setTimeout(() => searchPanel.querySelector('input')?.focus(), 0);
    });
  }

  const readPreference = () => {
    try {
      const value = localStorage.getItem(storageKey);
      if (value === 'light' || value === 'dark' || value === 'auto') return value;
    } catch (_) {}
    return 'auto';
  };

  const applyTheme = (preference) => {
    const resolved = preference === 'auto' ? (media.matches ? 'dark' : 'light') : preference;
    document.documentElement.dataset.theme = resolved;
    document.documentElement.dataset.themePreference = preference;
    document.documentElement.style.colorScheme = resolved;
    if (themeColor) themeColor.content = resolved === 'dark' ? '#111318' : '#f8fafd';
    if (themeButton) {
      themeButton.title = 'Appearance: ' + preference[0].toUpperCase() + preference.slice(1);
    }
    themeChoices.forEach((item) => {
      item.setAttribute('aria-checked', item.dataset.themeChoice === preference ? 'true' : 'false');
    });
  };

  let preference = readPreference();
  applyTheme(preference);

  if (themeButton && themeMenu) {
    themeButton.addEventListener('click', (event) => {
      event.stopPropagation();
      const opening = themeMenu.hasAttribute('hidden');
      themeMenu.toggleAttribute('hidden', !opening);
      themeButton.setAttribute('aria-expanded', opening ? 'true' : 'false');
    });

    themeChoices.forEach((item) => {
      item.addEventListener('click', () => {
        preference = item.dataset.themeChoice || 'auto';
        try { localStorage.setItem(storageKey, preference); } catch (_) {}
        applyTheme(preference);
        themeMenu.setAttribute('hidden', '');
        themeButton.setAttribute('aria-expanded', 'false');
      });
    });

    document.addEventListener('click', (event) => {
      if (!themeMenu.hasAttribute('hidden') && !event.target.closest('.theme-control')) {
        themeMenu.setAttribute('hidden', '');
        themeButton.setAttribute('aria-expanded', 'false');
      }
    });
  }

  media.addEventListener('change', () => {
    if (preference === 'auto') applyTheme(preference);
  });
})();
