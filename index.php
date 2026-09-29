<?php get_header(); ?>
<div class="fw-shell">
    <?php if (is_home() && !is_paged()) : ?>
        <header class="home-intro">
            <div>
                <h1><?php bloginfo('name'); ?></h1>
                <?php if (get_bloginfo('description')) : ?><p><?php bloginfo('description'); ?></p><?php endif; ?>
            </div>
        </header>
    <?php elseif (is_archive()) : ?>
        <header class="archive-header">
            <?php the_archive_title('<h1>', '</h1>'); ?>
            <?php the_archive_description('<p>', '</p>'); ?>
        </header>
    <?php elseif (is_search()) : ?>
        <header class="search-header">
            <h1><?php printf(esc_html__('Search results for “%s”', 'fwerkor-blog'), esc_html(get_search_query())); ?></h1>
        </header>
    <?php endif; ?>

    <div class="content-grid">
        <section class="posts-stack" aria-label="<?php esc_attr_e('Posts', 'fwerkor-blog'); ?>">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/post-card'); ?>
            <?php endwhile; ?>
                <div class="fw-pagination"><?php the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'fwerkor-blog'),
                    'next_text' => __('Next', 'fwerkor-blog'),
                ]); ?></div>
            <?php else : ?>
                <div class="empty-state">
                    <h2><?php esc_html_e('Nothing here yet', 'fwerkor-blog'); ?></h2>
                    <p><?php esc_html_e('Try another search or browse a category.', 'fwerkor-blog'); ?></p>
                </div>
            <?php endif; ?>
        </section>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
