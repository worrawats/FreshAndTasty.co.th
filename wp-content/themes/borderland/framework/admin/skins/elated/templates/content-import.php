<div class="eltdf-tabs-content">
    <div class="tab-content">
        <div class="tab-pane fade in active" id="import">
            <div class="eltdf-tab-content">
                <h2 class="eltdf-page-title">Import</h2>
                <form method="post" class="eltd_ajax_form eltdf-import-page-holder">
                    <div class="eltdf-page-form">
                        <div class="eltdf-page-form-section-holder">
                            <h3 class="eltdf-page-section-title">Import Demo Content</h3>
                            <div class="eltdf-page-form-section">
                                <div class="eltdf-field-desc">
                                    <h4>Import</h4>

                                    <p>Choose demo content you want to import</p>
                                </div>
                                <!-- close div.eltdf-field-desc -->

                                <div class="eltdf-section-content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <select name="import_example" id="import_example" class="form-control eltdf-form-element dependence">
                                                    <option value="borderland1">1 Sierra</option>
                                                    <option value="borderland2">2 Steppe</option>
                                                    <option value="borderland3">3 Range</option>
                                                    <option value="borderland4">4 Bronco</option>
                                                    <option value="borderland5">5 Pasture</option>
                                                    <option value="borderland6">6 Mesa</option>
                                                    <option value="borderland7">7 Maverick</option>
                                                    <option value="borderland8">8 Riata</option>
                                                    <option value="borderland9">9 Rockies</option>
                                                    <option value="borderland10">10 Plateau</option>
                                                    <option value="borderland11">11 Canyon</option>
                                                    <option value="borderland12">12 Outback</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- close div.eltdf-section-content -->

                            </div>

                            <div class="eltdf-page-form-section">


                                <div class="eltdf-field-desc">
                                    <h4>Import Type</h4>

                                    <p>Enabling this option will switch to a Side Position (default is Top Position)</p>
                                </div>
                                <!-- close div.eltdf-field-desc -->



                                <div class="eltdf-section-content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <select name="import_option" id="import_option" class="form-control eltdf-form-element">
                                                    <option value="">Please Select</option>
                                                    <option value="complete_content">All</option>
                                                    <option value="content">Content</option>
                                                    <option value="widgets">Widgets</option>
                                                    <option value="options">Options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- close div.eltdf-section-content -->

                            </div>
                            <div class="eltdf-page-form-section">


                                <div class="eltdf-field-desc">
                                    <h4>Import attachments</h4>

                                    <p>Do you want to import media files?</p>
                                </div>
                                <!-- close div.eltdf-field-desc -->
                                <div class="eltdf-section-content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="field switch">
                                                    <label class="cb-enable dependence"><span>Yes</span></label>
                                                    <label class="cb-disable selected dependence"><span>No</span></label>
                                                    <input type="checkbox" id="import_attachments" class="checkbox" name="import_attachments" value="1">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- close div.eltdf-section-content -->
                            </div>
                            <div class="eltdf-page-form-section">


                                <div class="eltdf-field-desc">
                                    <input type="submit" class="btn btn-primary btn-sm " value="Import" name="import" id="import_demo_data" />
                                </div>
                                <!-- close div.eltdf-field-desc -->
                                <div class="eltdf-section-content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="import_load"><span><?php _e('The import process may take some time. Please be patient.', 'eltd') ?> </span><br />
                                                    <div class="eltd-progress-bar-wrapper html5-progress-bar">
                                                        <div class="progress-bar-wrapper">
                                                            <progress id="progressbar" value="0" max="100"></progress>
                                                        </div>
                                                        <div class="progress-value">0%</div>
                                                        <div class="progress-bar-message">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- close div.eltdf-section-content -->
                            </div>
                            <div class="eltdf-page-form-section eltdf-import-button-wrapper">

                                <div class="alert alert-warning">
                                    <strong><?php _e('Important notes:', 'eltd') ?></strong>
                                    <ul>
                                        <li><?php _e('Please note that import process will take time needed to download all attachments from demo web site.', 'eltd'); ?></li>
                                        <li> <?php _e('If you plan to use shop, please install WooCommerce before you run import.', 'eltd')?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div><!-- close eltdf-tab-content -->
        </div>
    </div>
</div> <!-- close div.eltdf-tabs-content -->

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $(document).on('click', '#import_demo_data', function(e) {
                e.preventDefault();
                if (confirm('Are you sure, you want to import Demo Data now?')) {
                    $('.import_load').css('display','block');
                    var progressbar = $('#progressbar');
                    var import_opt = $( "#import_option" ).val();
                    var import_expl = $( "#import_example" ).val();
                    var p = 0;
                    if(import_opt == 'content'){
                        for(var i=1;i<10;i++){
                            var str;
                            if (i < 10) str = 'borderland_content_0'+i+'.xml';
                            else str = 'borderland_content_'+i+'.xml';
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: 'eltd_dataImport',
                                    xml: str,
                                    example: import_expl,
                                    import_attachments: ($("#import_attachments").is(':checked') ? 1 : 0)
                                },
                                success: function(data, textStatus, XMLHttpRequest){
                                    p+= 10;
                                    $('.progress-value').html((p) + '%');
                                    progressbar.val(p);
                                    if (p == 90) {
                                        str = 'borderland_content_10.xml';
                                        jQuery.ajax({
                                            type: 'POST',
                                            url: ajaxurl,
                                            data: {
                                                action: 'eltd_dataImport',
                                                xml: str,
                                                example: import_expl,
                                                import_attachments: ($("#import_attachments").is(':checked') ? 1 : 0)
                                            },
                                            success: function(data, textStatus, XMLHttpRequest){
                                                p+= 10;
                                                $('.progress-value').html((p) + '%');
                                                progressbar.val(p);
                                                $('.progress-bar-message').html('<div class="alert alert-success"><strong>Import is completed</strong></div>');
                                            },
                                            error: function(MLHttpRequest, textStatus, errorThrown){
                                            }
                                        });
                                    }
                                },
                                error: function(MLHttpRequest, textStatus, errorThrown){
                                }
                            });
                        }
                    } else if(import_opt == 'widgets') {
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                action: 'eltd_widgetsImport',
                                example: import_expl
                            },
                            success: function(data, textStatus, XMLHttpRequest){
                                $('.progress-value').html((100) + '%');
                                progressbar.val(100);
                            },
                            error: function(MLHttpRequest, textStatus, errorThrown){
                            }
                        });
                        $('.progress-bar-message').html('<div class="alert alert-success"><strong>Import is completed</strong></div>');
                    } else if(import_opt == 'options'){
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                action: 'eltd_optionsImport',
                                example: import_expl
                            },
                            success: function(data, textStatus, XMLHttpRequest){
                                $('.progress-value').html((100) + '%');
                                progressbar.val(100);
                            },
                            error: function(MLHttpRequest, textStatus, errorThrown){
                            }
                        });
                        $('.progress-bar-message').html('<div class="alert alert-success"><strong>Import is completed</strong></div>');
                    }else if(import_opt == 'complete_content'){
                        for(var i=1;i<10;i++){
                            var str;
                            if (i < 10) str = 'borderland_content_0'+i+'.xml';
                            else str = 'borderland_content_'+i+'.xml';
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: 'eltd_dataImport',
                                    xml: str,
                                    example: import_expl,
                                    import_attachments: ($("#import_attachments").is(':checked') ? 1 : 0)
                                },
                                success: function(data, textStatus, XMLHttpRequest){
                                    p+= 10;
                                    $('.progress-value').html((p) + '%');
                                    progressbar.val(p);
                                    if (p == 90) {
                                        str = 'borderland_content_10.xml';
                                        jQuery.ajax({
                                            type: 'POST',
                                            url: ajaxurl,
                                            data: {
                                                action: 'eltd_dataImport',
                                                xml: str,
                                                example: import_expl,
                                                import_attachments: ($("#import_attachments").is(':checked') ? 1 : 0)
                                            },
                                            success: function(data, textStatus, XMLHttpRequest){
                                                jQuery.ajax({
                                                    type: 'POST',
                                                    url: ajaxurl,
                                                    data: {
                                                        action: 'eltd_otherImport',
                                                        example: import_expl
                                                    },
                                                    success: function(data, textStatus, XMLHttpRequest){
                                                        //alert(data);
                                                        $('.progress-value').html((100) + '%');
                                                        progressbar.val(100);
                                                        $('.progress-bar-message').html('<div class="alert alert-success">Import is completed.</div>');
                                                    },
                                                    error: function(MLHttpRequest, textStatus, errorThrown){
                                                    }
                                                });
                                            },
                                            error: function(MLHttpRequest, textStatus, errorThrown){
                                            }
                                        });
                                    }
                                },
                                error: function(MLHttpRequest, textStatus, errorThrown){
                                }
                            });
                        }
                    }
                }
                return false;
            });
        });
    })(jQuery);

</script>