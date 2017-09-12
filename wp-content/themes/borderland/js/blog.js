var $j = jQuery.noConflict();

$j(document).ready(function() {
	"use strict";

	fitAudio();
    initLoadNextPostOnBottom();
});

$j(window).load(function() {
	"use strict";

	initBlog();
	initBlogMasonryFullWidth();
});

$j(window).resize(function() {
    "use strict";
    
	fitAudio();
	initBlog();
	initBlogMasonryFullWidth();
});

/*
 **	Init audio player for blog layout
 */
function fitAudio(){
	"use strict";

	$j('audio.blog_audio').mediaelementplayer({
		audioWidth: '100%'
	});
}
/*
 **	Init masonry layout for blog template
 */
function initBlog(){
	"use strict";

	if($j('.blog_holder.masonry').length){

		var $container = $j('.blog_holder.masonry');

		$container.isotope({
			itemSelector: 'article',
			resizable: false,
			masonry: {
				columnWidth: '.blog_holder_grid_sizer',
				gutter: '.blog_holder_grid_gutter'
			}
		});

		$j('.filter').click(function(){
			var selector = $j(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});

		if( $container.hasClass('masonry_infinite_scroll')){
			$container.infinitescroll({
					navSelector  : '.blog_infinite_scroll_button span',
					nextSelector : '.blog_infinite_scroll_button span a',
					itemSelector : 'article',
					loading: {
						finishedMsg: finished_text,
						msgText  : loading_text
					}
				},
				// call Isotope as a callback
				function( newElements ) {
					$container.isotope( 'appended', $j( newElements ) );
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry').isotope( 'layout');
					},400);
				}
			);
		}else if($container.hasClass('masonry_load_more')){

			var i = 1;
			$j('.blog_load_more_button a').on('click', function(e)  {
				e.preventDefault();

				var link = $j(this).attr('href');
				var $content = '.masonry_load_more';
				var $anchor = '.blog_load_more_button a';
				var $next_href = $j($anchor).attr('href');
				$j.get(link+'', function(data){
					var $new_content = $j($content, data).wrapInner('').html();
					$next_href = $j($anchor, data).attr('href');
					$container.append( $j( $new_content) ).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry').isotope( 'layout');
					},400);
					if($j('.blog_load_more_button span').data('rel') > i) {
						$j('.blog_load_more_button a').attr('href', $next_href); // Change the next URL
					} else {
						$j('.blog_load_more_button').remove();
					}
				});
				i++;
			});
		}

		$j('.blog_holder.masonry, .blog_load_more_button_holder').animate({opacity: "1"}, 400, function(){
			$j('.blog_holder.masonry').isotope( 'layout');
		});
	}
}

/*
 **	Init full width masonry layout for blog template
 */
function initBlogMasonryFullWidth(){
	"use strict";

	if($j('.masonry_full_width').length){

		var $container = $j('.masonry_full_width');

		$j('.filter').click(function(){
			var selector = $j(this).attr('data-filter');
			$container.isotope({ filter: selector });
			return false;
		});

		if( $container.hasClass('masonry_infinite_scroll')){
			$container.infinitescroll({
					navSelector  : '.blog_infinite_scroll_button span',
					nextSelector : '.blog_infinite_scroll_button span a',
					itemSelector : 'article',
					loading: {
						finishedMsg: finished_text,
						msgText  : loading_text
					}
				},
				// call Isotope as a callback
				function( newElements ) {
					$container.isotope( 'appended', $j( newElements ) );
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry_full_width').isotope( 'layout');
					},400);
				}
			);
		} else if($container.hasClass('masonry_load_more')){

			var i = 1;
			$j('.blog_load_more_button a').on('click', function(e)  {
				e.preventDefault();

				var link = $j(this).attr('href');
				var $content = '.masonry_load_more';
				var $anchor = '.blog_load_more_button a';
				var $next_href = $j($anchor).attr('href');
				$j.get(link+'', function(data){
					var $new_content = $j($content, data).wrapInner('').html();
					$next_href = $j($anchor, data).attr('href');
					$container.append( $j( $new_content) ).isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });
					fitVideo();
					fitAudio();
					initFlexSlider();
					setTimeout(function(){
						$j('.blog_holder.masonry_full_width').isotope( 'layout');
					},400);
					if($j('.blog_load_more_button span').data('rel') > i) {
						$j('.blog_load_more_button a').attr('href', $next_href); // Change the next URL
					} else {
						$j('.blog_load_more_button').remove();
					}
				});
				i++;
			});
		}

		$container.isotope({
			itemSelector: 'article',
			resizable: false,
			masonry: {
				columnWidth: '.blog_holder_grid_sizer',
				gutter: '.blog_holder_grid_gutter'
			}
		});

		$j('.masonry_full_width, .blog_load_more_button_holder').animate({opacity: "1"}, 400, function(){
			$j('.blog_holder.masonry_full_width').isotope( 'layout');
		});
	}
}


function initLoadNextPostOnBottom(){
    "use strict";
    if($j('.blog_vertical_loop').length) {
		var header_addition;
		var normal_header_addition;
		var paspartu_add = $j('body').hasClass('paspartu_enabled') ? Math.round($window_width*paspartu_width) : 0;
		
		if($j('header.page_header').hasClass('transparent')) {
			normal_header_addition = 0;
		}else{
			normal_header_addition = header_height;
		}
	
		var click = true;
		
        var $container = $j('.blog_vertical_loop .blog_holder');
        $j(document).on('click','.blog_vertical_loop_button a',function(e){
            e.preventDefault();
			if(click){
				click = false;
				var $this = $j(this);
				
				var link = $this.attr('href');
				var $content = '.blog_vertical_loop .blog_holder';
				var $anchor = '.blog_vertical_loop_button_holder a';
				var $next_href = $j($anchor).attr('href');
				
				//check for mobile header
				if($window_width < 1000){
					header_addition = $j('header.page_header').height();
				}else{
					header_addition = normal_header_addition;
				}
				
				var scrollTop = $j(window).scrollTop(),
					elementOffset = $this.closest('article').offset().top,
					distance = (elementOffset - scrollTop) - header_addition - paspartu_add;

				$container.find('article:eq(1)').addClass('fade_out');
				$this.closest('article').addClass('move_up').removeClass('next_post').css('transform', 'translateY(-' + distance + 'px)');
				setTimeout(function () {
					$j(window).scrollTop(0);
					$container.find('article:eq(0)').remove();
					$container.find('article:eq(0)').addClass('previous_post');
					$this.closest('article').removeAttr('style').removeClass('move_up');
				}, 450);


				$j.get(link + '', function (data) {
					var $new_content = $j(data).find('article').addClass('next_post');
					$next_href = $j($anchor, data).attr('href');
					$container.append($j($new_content));
					click = true;
				});
			}
			else{
				return false;
			}
        });
		
		$j(document).on('click','.blog_vertical_loop_back_button a',function(e){
			e.preventDefault();
			if(click){
				click = false;
				var $this = $j(this);
				
				var link = $this.attr('href');
				var $content = '.blog_vertical_loop .blog_holder';
				var $anchor = '.blog_vertical_loop_button_holder.prev_post a';
				var $prev_href = $j($anchor).attr('href');
				
				$container.find('article:eq(0)').removeClass('fade_out').addClass('fade_in');
				$this.closest('article').addClass('move_up').css('transform', 'translateY(' + $window_height + 'px)');
				setTimeout(function () {
					$container.find('article:last-child').remove();
					$container.find('article:eq(0)').removeClass('previous_post fade_in');
					$this.closest('article').addClass('next_post').removeAttr('style').removeClass('move_up');
					
					$j.get(link + '', function (data) {
						var $new_content = $j(data).find('article').removeClass('next_post').addClass('previous_post'); //by default, posts have next_post class
						$prev_href = $j($anchor, data).attr('href');
						$container.prepend($j($new_content));
						click = true;
					});
					
				}, 450);
				
			}else{
				return false;
			}
			
		});
		
		//load previous post on page load
		$j.get($j('.blog_vertical_loop_button_holder .last_page a').attr('href') + '', function (data) {
			var $new_content = $j(data).find('article').removeClass('next_post').addClass('previous_post'); //by default, posts have next_post class
			$container.prepend($j($new_content));
		});
		//load next post on page load
		$j.get($j('.blog_vertical_loop_button a').attr('href') + '', function (data) {
			var $new_content = $j(data).find('article').addClass('next_post');
			$container.append($j($new_content));
		});
    }
}