<?php get_header(); ?>
<div class="fw-shell article-layout">
    <div>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('article-shell'); ?>>
                <header class="article-header">
                    <h1 class="article-title"><?php the_title(); ?></h1>
                    <?php fwerkor_blog_post_meta(); ?>
                </header>
                <?php if (has_post_thumbnail()) : ?><figure class="article-hero"><?php the_post_thumbnail('large'); ?></figure><?php endif; ?>
                <div class="entry-content"><?php the_content(); wp_link_pages(); ?></div>
                <?php $tags = get_the_tags(); if ($tags) : ?>
                    <div class="post-taxonomy">
                        <?php foreach ($tags as $tag) : ?><a href="<?php echo esc_url(get_tag_link($tag)); ?>">#<?php echo esc_html($tag->name); ?></a><?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
            <nav class="post-navigation" aria-label="<?php esc_attr_e('Post navigation', 'fwerkor-blog'); ?>">
                <div class="nav-previous"><?php previous_post_link('%link', '← %title'); ?></div>
                <div class="nav-next"><?php next_post_link('%link', '%title →'); ?></div>
            </nav>
            <?php if (comments_open() || get_comments_number()) { comments_template(); } ?>
        <?php endwhile; ?>
    </div>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
