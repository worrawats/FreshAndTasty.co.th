<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div><label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" value="" placeholder="<?php _e('Search Here', 'eltd'); ?>" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="&#x55;" />
    </div>
</form>