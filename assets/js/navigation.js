(() => {
  const nav = document.getElementById('site-navigation');
  const menuButton = document.querySelector('.menu-toggle');
  const searchButton = document.querySelector('.search-toggle');
  const searchPanel = document.getElementById('site-search-panel');

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
})();
