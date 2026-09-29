<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <a class="header-action account-link" href="https://account.fwerkor.com/"><?php esc_html_e('Account', 'fwerkor-blog'); ?></a>
            <button class="header-action menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false"><?php esc_html_e('Menu', 'fwerkor-blog'); ?></button>
        </div>
    </div>
    <div class="search-panel" id="site-search-panel" hidden>
        <div class="fw-shell"><?php get_search_form(); ?></div>
    </div>
</header>
<main id="content" class="site-main">
