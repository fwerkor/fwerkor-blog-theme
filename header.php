<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8fafd" id="fw-theme-color">
    <script>
    (() => {
      const key = 'fwerkor-color-mode';
      let preference = 'auto';
      try {
        const saved = localStorage.getItem(key);
        if (saved === 'light' || saved === 'dark' || saved === 'auto') preference = saved;
      } catch (_) {}
      const dark = preference === 'dark' ||
        (preference === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
      document.documentElement.dataset.theme = dark ? 'dark' : 'light';
      document.documentElement.dataset.themePreference = preference;
      document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
    })();
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'fwerkor-blog'); ?></a>
<header class="site-header">
    <div class="fw-shell header-inner">
        <div class="site-branding">
            <?php if (has_custom_logo()) { the_custom_logo(); } ?>
            <a class="brand-copy" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                <span class="site-title"><?php bloginfo('name'); ?></span>
                <?php if (get_bloginfo('description')) : ?>
                    <span class="site-description"><?php bloginfo('description'); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <nav class="site-nav" id="site-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'fwerkor-blog'); ?>">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'fallback_cb' => 'fwerkor_blog_fallback_menu',
                'depth' => 1,
            ]); ?>
        </nav>

        <div class="header-actions">
            <button class="header-action search-toggle" type="button" aria-controls="site-search-panel" aria-expanded="false"><?php esc_html_e('Search', 'fwerkor-blog'); ?></button>
            <div class="theme-control">
                <button class="header-action theme-toggle" type="button" aria-controls="theme-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Appearance', 'fwerkor-blog'); ?>" title="<?php esc_attr_e('Appearance', 'fwerkor-blog'); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 3a9 9 0 1 0 9 9 9.01 9.01 0 0 0-9-9Zm0 16V5a7 7 0 0 1 0 14Z"/></svg>
                </button>
                <div class="theme-menu" id="theme-menu" role="menu" hidden>
                    <button class="theme-option" type="button" role="menuitemradio" data-theme-choice="auto">Auto</button>
                    <button class="theme-option" type="button" role="menuitemradio" data-theme-choice="light">Light</button>
                    <button class="theme-option" type="button" role="menuitemradio" data-theme-choice="dark">Dark</button>
                </div>
            </div>
            <a class="header-action account-link" href="https://account.fwerkor.com/"><?php esc_html_e('Account', 'fwerkor-blog'); ?></a>
            <button class="header-action menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false"><?php esc_html_e('Menu', 'fwerkor-blog'); ?></button>
        </div>
    </div>
    <div class="search-panel" id="site-search-panel" hidden>
        <div class="fw-shell"><?php get_search_form(); ?></div>
    </div>
</header>
<main id="content" class="site-main">
