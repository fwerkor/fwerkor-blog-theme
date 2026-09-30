<?php
if (!defined('ABSPATH')) { exit; }

define('FWERKOR_BLOG_VERSION', '1.2.0');

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


function fwerkor_blog_customize_register(WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_section('fwerkor_blog_theme_options', [
        'title'    => __('FWERKOR Blog', 'fwerkor-blog'),
        'priority' => 160,
    ]);

    $wp_customize->add_setting('fwerkor_blog_account_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('fwerkor_blog_account_url', [
        'type'        => 'url',
        'section'     => 'fwerkor_blog_theme_options',
        'label'       => __('Account URL', 'fwerkor-blog'),
        'description' => __('Optional. Leave empty to hide the Account action in the header.', 'fwerkor-blog'),
        'input_attrs' => [
            'placeholder' => 'https://example.com/account',
        ],
    ]);
}
add_action('customize_register', 'fwerkor_blog_customize_register');

/**
 * Theme-native code syntax highlighting.
 *
 * Keeps the serialized language, lineNumbers, and title attributes used by
 * the previous Code Syntax Block plugin so existing posts remain editable.
 */
function fwerkor_blog_code_languages(): array {
    return [
        'apacheconf' => 'Apache Config',
        'adoc' => 'Asciidoc',
        'bash' => 'Bash/Shell',
        'basic' => 'BASIC',
        'c' => 'C',
        'csharp' => 'C#',
        'cpp' => 'C++',
        'css' => 'CSS',
        'dart' => 'Dart',
        'django' => 'Django',
        'docker' => 'Docker',
        'fsharp' => 'F#',
        'graphql' => 'GraphQL',
        'go' => 'Go',
        'haskell' => 'Haskell',
        'markup' => 'HTML',
        'java' => 'Java',
        'javascript' => 'JavaScript',
        'json' => 'JSON',
        'kotlin' => 'Kotlin',
        'lisp' => 'Lisp',
        'markdown' => 'Markdown',
        'matlab' => 'MATLAB',
        'nginx' => 'nginx',
        'objectivec' => 'Objective-C',
        'php' => 'PHP',
        'powershell' => 'PowerShell',
        'properties' => '.properties',
        'python' => 'Python',
        'jsx' => 'React JSX',
        'ruby' => 'Ruby',
        'rust' => 'Rust',
        'sass' => 'Sass',
        'sql' => 'SQL',
        'svg' => 'SVG',
        'swift' => 'Swift',
        'toml' => 'TOML',
        'typescript' => 'TypeScript',
        'vim' => 'vim',
        'visual-basic' => 'Visual Basic',
        'wasm' => 'WebAssembly',
        'xml' => 'XML',
        'yaml' => 'YAML',
    ];
}

function fwerkor_blog_page_has_code(): bool {
    global $posts;
    foreach ((array) $posts as $post) {
        if ($post instanceof WP_Post && has_block('core/code', $post)) {
            return true;
        }
    }
    return false;
}

function fwerkor_blog_code_frontend_assets(): void {
    if (is_admin() || !fwerkor_blog_page_has_code()) {
        return;
    }

    $uri = get_template_directory_uri();
    $dir = get_template_directory();

    wp_enqueue_script(
        'fwerkor-blog-prism',
        $uri . '/assets/vendor/prism/prism.js',
        [],
        (string) filemtime($dir . '/assets/vendor/prism/prism.js'),
        true
    );
    wp_add_inline_script(
        'fwerkor-blog-prism',
        'window.FWERKOR_CODE=' . wp_json_encode([
            'prismComponents' => $uri . '/assets/vendor/prism/prism-components/',
        ]) . ';',
        'before'
    );

    wp_enqueue_script(
        'fwerkor-blog-code-highlight',
        $uri . '/assets/js/code-highlight.js',
        ['fwerkor-blog-prism'],
        FWERKOR_BLOG_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'fwerkor_blog_code_frontend_assets', 20);

function fwerkor_blog_code_editor_assets(): void {
    $uri = get_template_directory_uri();
    $dir = get_template_directory();

    wp_enqueue_style(
        'fwerkor-blog-code-editor',
        $uri . '/assets/css/code-editor.css',
        [],
        (string) filemtime($dir . '/assets/css/code-editor.css')
    );

    wp_enqueue_script(
        'fwerkor-blog-code-editor',
        $uri . '/assets/js/code-block-editor.js',
        ['wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-element', 'wp-hooks', 'wp-i18n'],
        (string) filemtime($dir . '/assets/js/code-block-editor.js'),
        true
    );

    wp_add_inline_script(
        'fwerkor-blog-code-editor',
        'window.FWERKOR_CODE_EDITOR=' . wp_json_encode([
            'languages' => fwerkor_blog_code_languages(),
            'defaultLanguage' => sanitize_key((string) get_option('mkaz-code-syntax-default-lang', '')),
        ]) . ';',
        'before'
    );
}
add_action('enqueue_block_editor_assets', 'fwerkor_blog_code_editor_assets');

function fwerkor_blog_allow_code_lang_attribute(array $tags): array {
    if (!isset($tags['code']) || !is_array($tags['code'])) {
        $tags['code'] = [];
    }
    $tags['code']['lang'] = true;
    return $tags;
}
add_filter('wp_kses_allowed_html', 'fwerkor_blog_allow_code_lang_attribute');
