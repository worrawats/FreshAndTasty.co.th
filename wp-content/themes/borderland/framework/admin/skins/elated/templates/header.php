<div class="eltdf-page-header page-header clearfix">

    <div class="eltdf-theme-name pull-left" >
        <img src="<?php echo esc_url(eltd_get_skin_uri() . '/assets/img/logo.png'); ?>" alt="eltd_logo" class="eltdf-header-logo pull-left"/>
        <?php $current_theme = wp_get_theme(); ?>
        <h1 class="pull-left">
            <?php echo esc_html($current_theme->get('Name')); ?>
            <small><?php echo esc_html($current_theme->get('Version')); ?></small>
        </h1>
    </div>
    <div class="eltdf-top-section-holder">
        <div class="eltdf-top-section-holder-inner">
            <?php $this->getAnchors($active_page); ?>
            <div class="eltdf-top-buttons-holder">
                <?php if($show_save_btn) { ?>
                    <input type="button" id="eltd_top_save_button" class="btn btn-info btn-sm" value="<?php _e('Save Changes', 'eltd'); ?>"/>
                <?php } ?>
            </div>

            <?php if($show_save_btn) { ?>
                <div class="eltdf-input-change"><i class="fa fa-exclamation-circle"></i>You should save your changes</div>
                <div class="eltdf-changes-saved"><i class="fa fa-check-circle"></i>All your changes are successfully saved</div>
            <?php } ?>
        </div>
    </div>

</div> <!-- close div.eltdf-page-header -->