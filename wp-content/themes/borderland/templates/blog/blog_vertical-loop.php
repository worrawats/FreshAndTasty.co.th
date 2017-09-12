<?php
global $eltd_options;
global $more;
$more = 0;
$category = get_post_meta($id, "eltd_choose-blog-category", true);

$blog_show_categories = "no";
if (isset($eltd_options['blog_vertical_loop_type_show_categories'])){
    $blog_show_categories = $eltd_options['blog_vertical_loop_type_show_categories'];
}

$blog_show_comments = "yes";
if (isset($eltd_options['blog_vertical_loop_type_show_comments'])){
    $blog_show_comments = $eltd_options['blog_vertical_loop_type_show_comments'];
}
$blog_show_author = "yes";
if (isset($eltd_options['blog_vertical_loop_type_show_author'])){
    $blog_show_author = $eltd_options['blog_vertical_loop_type_show_author'];
}
$blog_show_like = "yes";
if (isset($eltd_options['blog_vertical_loop_type_show_like'])) {
    $blog_show_like = $eltd_options['blog_vertical_loop_type_show_like'];
}
$blog_show_ql_icon_mark = "yes";
$blog_title_holder_icon_class = "";
if (isset($eltd_options['blog_vertical_loop_type_show_ql_mark'])) {
    $blog_show_ql_icon_mark = $eltd_options['blog_vertical_loop_type_show_ql_mark'];
}
if($blog_show_ql_icon_mark == "yes"){
    $blog_title_holder_icon_class = " with_icon_right";
}

$blog_show_date = "yes";
if (isset($eltd_options['blog_vertical_loop_type_show_date'])) {
    $blog_show_date = $eltd_options['blog_vertical_loop_type_show_date'];
}
$blog_show_social_share = "no";
$blog_social_share_type = "dropdown";
if(isset($eltd_options['blog_vertical_loop_type_select_share_option'])){
    $blog_social_share_type = $eltd_options['blog_vertical_loop_type_select_share_option'];
}
if (isset($eltd_options['enable_social_share'])&& ($eltd_options['enable_social_share']) =="yes"){
    if (isset($eltd_options['post_types_names_post'])&& $eltd_options['post_types_names_post'] =="post"){
        if (isset($eltd_options['blog_vertical_loop_type_show_share'])&& $blog_social_share_type == "dropdown") {
            $blog_show_social_share = $eltd_options['blog_vertical_loop_type_show_share'];
        }
    }
}


if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
if($paged == 1){
    $next_post_class = '';
	$preload_background_class = "preload_background";
}else{
    $next_post_class = 'next_post';
	$preload_background_class = "";
}

$number_of_pages = intval($wp_query->max_num_pages);
if($paged - 2 == 0){
	$previous_page = $number_of_pages;
}else if($paged - 2 < 0){
	$previous_page = $number_of_pages - 1;
}else{
	$previous_page = $paged - 2;
}

$_post_format = get_post_format();
?>
<?php
switch ($_post_format) {
    case "video":
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
            
			<div class="grid_section blog_load_next">
				<div class="section_inner">
					<div class="blog_vertical_loop_button_holder">
						<?php if(get_next_posts_link()) { ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
						<?php }else{ ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
						<?php } ?>
					</div>
				</div>
			</div>
			
            <div class="post_content_holder">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="post_image">
						<div class="grid_section blog_load_prev">
							<div class="section_inner">
								<div class="blog_vertical_loop_button_holder prev_post">
									<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
									<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
								</div>
							</div>
						</div>
                        <div class="post_image_inner">
							<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>');"></a>
							<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
						</div>
                    </div>
                <?php } ?>
                <div class="grid_section">
                    <div class="section_inner">
                        <div class="post_text">
                            <div class="post_text_inner"> 
								<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
									<div class="post_subtitle">
										<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
									</div>	
								<?php } ?>
								<h2>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </h2>								
                                <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                    <div class="post_info">
                                        <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                    </div>
                                <?php } ?>
								
                                <?php the_content(); ?>
                                <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                    echo do_shortcode('[no_social_share_list]'); // XSS OK
                                }; ?>
								<a class="qbutton  small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
        break;
    case "audio":
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
            <div class="grid_section blog_load_next">
				<div class="section_inner">
					<div class="blog_vertical_loop_button_holder">
						<?php if(get_next_posts_link()) { ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
						<?php }else{ ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
						<?php } ?>
					</div>
				</div>
			</div>
			
            <div class="post_content_holder">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="post_image">
					
						<div class="grid_section blog_load_prev">
							<div class="section_inner">
								<div class="blog_vertical_loop_button_holder prev_post">
									<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
									<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
								</div>
							</div>
						</div>
						<div class="post_image_inner">
							<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>');"></a>
							<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
						</div>
                    </div>
                <?php } ?>
                <div class="grid_section">
                    <div class="section_inner">
                        <div class="post_text">
                            <div class="post_text_inner"> 
								<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
									<div class="post_subtitle">
										<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
									</div>	
								<?php } ?>
								<h2>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                    <div class="post_info">
                                        <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                    </div>
                                <?php } ?>
								
                                <?php the_content(); ?>
                                <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                    echo do_shortcode('[no_social_share_list]'); // XSS OK
                                }; ?>
								<a class="qbutton  small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
        break;
    case "link":
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
            <div class="grid_section blog_load_next">
				<div class="section_inner">
					<div class="blog_vertical_loop_button_holder">
						<?php if(get_next_posts_link()) { ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
						<?php }else{ ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
						<?php } ?>
					</div>
				</div>
			</div>
			
            <div class="post_content_holder">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="post_image">
					
						<div class="grid_section blog_load_prev">
							<div class="section_inner">
								<div class="blog_vertical_loop_button_holder prev_post">
									<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
									<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
								</div>
							</div>
						</div>
						<div class="post_image_inner">
							<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>');"></a>
							<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
						</div>
                    </div>
                <?php } ?>
                <div class="grid_section">
                    <div class="section_inner">
                        <div class="post_text_columns">
                            <div class="post_text">
                                <div class="post_text_inner">
									<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
										<div class="post_subtitle">
											<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
										</div>	
									<?php } ?>
                                    <?php if ($blog_show_ql_icon_mark == "yes") { ?>
                                        <div class="post_info_link_mark">
                                            <span class="fa fa-link link_mark"></span>
                                        </div>
                                    <?php } ?>
                                    <div class="post_title<?php echo esc_attr($blog_title_holder_icon_class); ?>">
                                        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                    <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                        <div class="post_info">
                                            <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                        echo do_shortcode('[no_social_share_list]'); // XSS OK
                                    }; ?>
                                </div>
                                <?php the_content();?>
								<a class="qbutton  small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
        break;
    case "gallery":
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
            <div class="grid_section blog_load_next">
				<div class="section_inner">
					<div class="blog_vertical_loop_button_holder">
						<?php if(get_next_posts_link()) { ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
						<?php }else{ ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
						<?php } ?>
					</div>
				</div>
			</div>
			
            <div class="post_content_holder">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="post_image">
					
						<div class="grid_section blog_load_prev">
							<div class="section_inner">
								<div class="blog_vertical_loop_button_holder prev_post">
									<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
									<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
								</div>
							</div>
						</div>
						<div class="post_image_inner">
							<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>');"></a>
							<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
						</div>
                    </div>
                <?php } ?>
                <div class="grid_section">
                    <div class="section_inner">
                        <div class="post_text">
                            <div class="post_text_inner">  
								<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
									<div class="post_subtitle">
										<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
									</div>	
								<?php } ?>
								<h2>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </h2>
								
                                <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                    <div class="post_info">
                                        <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                    </div>
                                <?php } ?>
								
                                <?php the_content(); ?>
                                <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                    echo do_shortcode('[no_social_share_list]'); // XSS OK
                                }; ?>
								<a class="qbutton  small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php
        break;
    case "quote":
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
            <div class="grid_section blog_load_next">
				<div class="section_inner">
					<div class="blog_vertical_loop_button_holder">
						<?php if(get_next_posts_link()) { ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
						<?php }else{ ?>
							<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
						<?php } ?>
					</div>
				</div>
			</div>
			
            <div class="post_content_holder">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="post_image">
						
						<div class="grid_section blog_load_prev">
							<div class="section_inner">
								<div class="blog_vertical_loop_button_holder prev_post">
									<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
									<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
								</div>
							</div>
						</div>
						<div class="post_image_inner">
							<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>');"></a>
							<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
						</div>
                    </div>
                <?php } ?>
                <div class="grid_section">
                    <div class="section_inner">
                        <div class="post_text_columns">
                            <div class="post_text">
                                <div class="post_text_inner">
									<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
										<div class="post_subtitle">
											<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
										</div>	
									<?php } ?>
                                    <?php if ($blog_show_ql_icon_mark == "yes") { ?>
                                        <div class="post_info_quote_mark">
                                            <span class="fa fa-quote-right quote_mark"></span>
                                        </div>
                                    <?php } ?>
                                    <div class="post_title<?php echo esc_attr($blog_title_holder_icon_class); ?>">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html(get_post_meta(get_the_ID(), "quote_format", true)); ?></a>
                                        </h3>
                                        <span class="quote_author">&mdash; <?php the_title(); ?></span>
                                    </div>
                                    <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                        <div class="post_info">
                                            <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                        echo do_shortcode('[no_social_share_list]'); // XSS OK
                                    }; ?>
                                </div>
                            </div>
                        </div>
                        <?php the_content(); ?>
						<a class="qbutton  small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                    </div>
                </div>
            </div>
        </article>
        <?php
        break;
    default:
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class($next_post_class); ?>>
				<div class="grid_section blog_load_next">
					<div class="section_inner">
						<div class="blog_vertical_loop_button_holder">
							<?php if(get_next_posts_link()) { ?>
								<div class="blog_vertical_loop_button"><span class="button_icon" ><?php echo wp_kses_post(get_next_posts_link('')); ?></span></div>
							<?php }else{ ?>
								<div class="blog_vertical_loop_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link(1, true)); ?>"></a></span></div>
							<?php } ?>
						</div>
					</div>
				</div>
				
                <div class="post_content_holder">
                    <?php if ( has_post_thumbnail() ) { ?>
                        <div class="post_image">
							<div class="grid_section blog_load_prev">
								<div class="section_inner">
									<div class="blog_vertical_loop_button_holder prev_post">
										<div class="last_page"><a href="<?php echo esc_url(get_pagenum_link($number_of_pages, true)); ?>"></a></div>
										<div class="blog_vertical_loop_back_button"><span class="button_icon" ><a href="<?php echo esc_url(get_pagenum_link($previous_page, true)); ?>"></a></span></div>
									</div>
								</div>
							</div>
							<div class="post_image_inner">
								<a class="<?php echo $preload_background_class; ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="background-image:url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>');"></a>
								<div class="post_image_title"><div class="post_image_title_inner"><div class="grid_section"><div class="section_inner"><h2><?php the_title(); ?></h2></div></div></div></div>
							</div>
                        </div>
                    <?php } ?>
                    <div class="grid_section">
                        <div class="section_inner">
                            <div class="post_text">
                                <div class="post_text_inner">
									<?php if(get_post_meta($id, "eltd_page_subtitle", true) != ""){ ?>
										<div class="post_subtitle">
											<span><?php echo esc_attr(get_post_meta($id, "eltd_page_subtitle", true))?></span>
										</div>	
									<?php } ?>
									<h2>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <?php if($blog_show_author == "yes" || $blog_show_date == "yes" || $blog_show_social_share == "yes" || $blog_show_categories == "yes" || $blog_show_comments == "yes" || $blog_show_like == "yes") { ?>
                                        <div class="post_info">
                                            <?php eltd_post_info(array('date' => $blog_show_date, 'author' => $blog_show_author, 'share' => $blog_show_social_share, 'category' => $blog_show_categories, 'comments' => $blog_show_comments, 'like' => $blog_show_like)); ?>
                                        </div>
                                    <?php } ?>
									
                                    <?php the_content();?>
                                    <?php if(isset($eltd_options['blog_vertical_loop_type_show_share']) && $eltd_options['blog_vertical_loop_type_show_share'] == "yes" && $blog_social_share_type == "list") {
                                        echo do_shortcode('[no_social_share_list]'); // XSS OK
                                    }; ?>
									<a class="qbutton small white loop_more" href="<?php the_permalink(); ?>"><?php _e('Post a comment', 'eltd'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php
}
?>

