</main>
<footer class="site-footer">
    <div class="fw-shell footer-inner">
        <div>
            <div class="footer-brand">
                <?php $logo = fwerkor_blog_logo_url(); ?>
                <?php if ($logo) : ?><img class="footer-logo" src="<?php echo esc_url($logo); ?>" alt=""><?php endif; ?>
                <span><?php bloginfo('name'); ?></span>
            </div>
            <div class="footer-meta">&copy; <?php echo esc_html(wp_date('Y')); ?> FWERKOR</div>
        </div>
        <nav class="footer-nav" aria-label="<?php esc_attr_e('Footer navigation', 'fwerkor-blog'); ?>">
            <?php wp_nav_menu([
                'theme_location' => 'footer',
                'container' => false,
                'fallback_cb' => false,
                'depth' => 1,
            ]); ?>
        </nav>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
