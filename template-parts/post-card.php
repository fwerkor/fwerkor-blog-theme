<article id="post-<?php the_ID(); ?>" <?php post_class('post-card' . (has_post_thumbnail() ? '' : ' no-thumb')); ?>>
    <div class="post-card-content">
        <?php fwerkor_blog_post_meta(); ?>
        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="post-excerpt"><?php the_excerpt(); ?></div>
        <div class="post-card-footer"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read article', 'fwerkor-blog'); ?> →</a></div>
    </div>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumb">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php the_post_thumbnail('medium_large', ['loading' => 'lazy']); ?></a>
        </div>
    <?php endif; ?>
</article>
