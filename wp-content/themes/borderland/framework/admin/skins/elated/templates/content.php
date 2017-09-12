<div class="eltdf-tabs-content">
    <div class="tab-content">

        <div class="tab-pane fade in active">
            <div class="eltdf-tab-content">
                <h2 class="eltdf-page-title"><?php echo esc_html($page->title); ?></h2>


                <form method="post" class="eltd_ajax_form">
                    <div class="eltdf-page-form">
                        <?php $page->render(); ?>
                    </div>
                </form>

            </div><!-- close eltdf-tab-content -->
        </div>

    </div>
</div> <!-- close div.eltdf-tabs-content -->