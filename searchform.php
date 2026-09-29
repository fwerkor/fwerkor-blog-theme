<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="fw-search"><?php esc_html_e('Search for:', 'fwerkor-blog'); ?></label>
    <input id="fw-search" type="search" class="search-field" placeholder="<?php esc_attr_e('Search articles', 'fwerkor-blog'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
    <button type="submit" class="search-submit"><?php esc_html_e('Search', 'fwerkor-blog'); ?></button>
</form>
