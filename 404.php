<?php get_header(); ?>
<div class="fw-shell">
    <section class="not-found">
        <h1><?php esc_html_e('Page not found', 'fwerkor-blog'); ?></h1>
        <p><?php esc_html_e('The page may have moved or no longer exists.', 'fwerkor-blog'); ?></p>
        <p><a class="fw-button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to blog', 'fwerkor-blog'); ?></a></p>
    </section>
</div>
<?php get_footer(); ?>
