<?php get_header(); ?>
<div class="fw-shell">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('article-shell'); ?> style="max-width:900px;margin-inline:auto">
            <header class="article-header"><h1 class="article-title"><?php the_title(); ?></h1></header>
            <div class="entry-content"><?php the_content(); wp_link_pages(); ?></div>
        </article>
        <?php if (comments_open() || get_comments_number()) { comments_template(); } ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
