<aside class="sidebar" aria-label="<?php esc_attr_e('Sidebar', 'fwerkor-blog'); ?>">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>
        <section class="sidebar-card sidebar-intro">
            <h2 class="sidebar-heading"><?php esc_html_e('FWERKOR', 'fwerkor-blog'); ?></h2>
            <p><?php bloginfo('description'); ?></p>
        </section>
        <section class="sidebar-card">
            <h2 class="sidebar-heading"><?php esc_html_e('Categories', 'fwerkor-blog'); ?></h2>
            <ul class="category-list">
                <?php foreach (get_categories(['hide_empty'=>true,'orderby'=>'count','order'=>'DESC','number'=>8]) as $category) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_category_link($category)); ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="category-count"><?php echo esc_html((string) $category->count); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="sidebar-card">
            <h2 class="sidebar-heading"><?php esc_html_e('Recent posts', 'fwerkor-blog'); ?></h2>
            <ul class="recent-list">
                <?php foreach (get_posts(['numberposts'=>6,'post_status'=>'publish']) as $recent_post) : ?>
                    <li><a href="<?php echo esc_url(get_permalink($recent_post)); ?>"><?php echo esc_html(get_the_title($recent_post)); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
</aside>
