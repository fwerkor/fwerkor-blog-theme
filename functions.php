<?php
if (!defined('ABSPATH')) { exit; }

define('FWERKOR_BLOG_VERSION', '1.0.0');

function fwerkor_blog_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('custom-logo', [
        'height' => 180, 'width' => 180, 'flex-height' => true, 'flex-width' => true,
    ]);
    add_theme_support('html5', [
        'search-form','comment-form','comment-list','gallery','caption','style','script',
    ]);
    register_nav_menus([
        'primary' => __('Primary navigation', 'fwerkor-blog'),
        'footer'  => __('Footer navigation', 'fwerkor-blog'),
    ]);
}
add_action('after_setup_theme', 'fwerkor_blog_setup');

function fwerkor_blog_assets(): void {
    wp_enqueue_style('fwerkor-blog-style', get_stylesheet_uri(), [], FWERKOR_BLOG_VERSION);
    wp_enqueue_script(
        'fwerkor-blog-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        [],
        FWERKOR_BLOG_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'fwerkor_blog_assets');

function fwerkor_blog_widgets_init(): void {
    register_sidebar([
        'name' => __('Sidebar', 'fwerkor-blog'),
        'id' => 'fwerkor-sidebar',
        'description' => __('Widgets shown beside post listings and articles.', 'fwerkor-blog'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
}
add_action('widgets_init', 'fwerkor_blog_widgets_init');

function fwerkor_blog_excerpt_length(int $length): int {
    return is_admin() ? $length : 34;
}
add_filter('excerpt_length', 'fwerkor_blog_excerpt_length', 99);
add_filter('excerpt_more', static fn(string $more): string => '…');

function fwerkor_blog_reading_time(int $post_id = 0): int {
    $post_id = $post_id ?: (int) get_the_ID();
    $content = wp_strip_all_tags((string) get_post_field('post_content', $post_id));
    $chars = function_exists('mb_strlen') ? mb_strlen($content) : strlen($content);
    return max(1, (int) ceil($chars / 500));
}

function fwerkor_blog_post_meta(bool $with_categories = true): void {
    ?>
    <div class="post-meta">
        <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date('Y-m-d')); ?></time>
        <span class="meta-dot"><?php echo esc_html((string) fwerkor_blog_reading_time()); ?> min</span>
        <?php if ($with_categories) :
            $categories = get_the_category();
            if ($categories) : ?>
                <span class="meta-dot">
                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html($categories[0]->name); ?></a>
                </span>
            <?php endif;
        endif; ?>
    </div>
    <?php
}

function fwerkor_blog_fallback_menu(array $args = []): void {
    $categories = get_categories([
        'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 3,
    ]);
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'fwerkor-blog') . '</a></li>';
    foreach ($categories as $category) {
        echo '<li><a href="' . esc_url(get_category_link($category)) . '">' . esc_html($category->name) . '</a></li>';
    }
    echo '</ul>';
}

function fwerkor_blog_logo_url(): string {
    $logo_id = (int) get_theme_mod('custom_logo');
    if ($logo_id) {
        $src = wp_get_attachment_image_src($logo_id, 'full');
        if ($src) { return (string) $src[0]; }
    }
    return '';
}
