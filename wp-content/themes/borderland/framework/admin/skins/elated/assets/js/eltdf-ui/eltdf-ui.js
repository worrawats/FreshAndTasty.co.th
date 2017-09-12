(function($){
	$(document).ready(function() {
		//plugins init goes here
		eltdfInitSelectChange();
		eltdfInitSwitch();
		eltdfInitTooltips();
		eltdfInitColorpicker();
		eltdfInitRangeSlider();
		eltdfInitMediaUploader();
		eltdfInitGalleryUploader();
		if ($('.eltdf-page-form').length > 0) {
			eltdfInitAjaxForm();
			eltdfAnchorSelectOnLoad();
			eltdfScrollToAnchorSelect();
			initTopAnchorHolderSize();
			eltdCheckVisibilityOfAnchorButtons();
			eltdfCheckVisibilityOfAnchorOptions();
			eltdCheckAnchorsOnDependencyChange();
			eltdfCheckOptionAnchorsOnDependencyChange();
			eltdChangedInput();
			eltdFixHeaderAndTitle();
			totop_button();
			backButtonShowHide();
			backToTop();
            eltdfInitSelectPicker();
		}
		eltdfInitPortfolioImagesVideosBox();
		eltdInitPortfolioMediaAcc();
		eltdfInitPortfolioItemsBox();
		eltdInitPortfolioItemAcc();
		eltdfInitDatePicker();
        eltdShowHidePostFormats();
		eltdRemoveVCDeprecatedClass();


    });

	function eltdFixHeaderAndTitle () {
		var pageHeader 				= $('.eltdf-page-header');
		var pageHeaderHeight		= pageHeader.height();
		var adminBarHeight			= $('#wpadminbar').height();
		var pageHeaderTopPosition 	= pageHeader.offset().top - parseInt(adminBarHeight);
		var pageTitle				= $('.eltdf-page-title');
		var pageTitleTopPosition	= pageHeaderHeight + adminBarHeight - parseInt(pageTitle.css('marginTop'));
		var tabsNavWrapper			= $('.eltdf-tabs-navigation-wrapper');
		var tabsNavWrapperTop		= pageHeaderHeight;
		var tabsContentWrapper	    = $('.eltdf-tab-content');
		var tabsContentWrapperTop	= pageHeaderHeight + pageTitle.outerHeight();

		$(window).on('scroll load', function() {
			if($(window).scrollTop() >= pageHeaderTopPosition) {
				pageHeader.addClass('eltd-header-fixed').css('top', parseInt(adminBarHeight));
				pageTitle.addClass('eltd-page-title-fixed').css('top', pageTitleTopPosition);
				tabsNavWrapper.css('marginTop', tabsNavWrapperTop);
				tabsContentWrapper.css('marginTop', tabsContentWrapperTop);
			} else {
				pageHeader.removeClass('eltd-header-fixed').css('top', 0);
				pageTitle.removeClass('eltd-page-title-fixed').css('top', 0);
				tabsNavWrapper.css('marginTop', 0);
				tabsContentWrapper.css('marginTop', 0);
			}
		});
	}

	function initTopAnchorHolderSize() {
		function initTopSize() {
			var optionsPageHolder = $('.eltdf-options-page');
			var anchorAndSaveHolder = $('.eltdf-top-section-holder');
			var pageTitle = $('.eltdf-page-title');
			var tabsContentWrapper = $('.eltdf-tabs-content');

			anchorAndSaveHolder.css('width', optionsPageHolder.width() - parseInt(anchorAndSaveHolder.css('margin-left')));
			pageTitle.css('width', tabsContentWrapper.outerWidth());
		}

		initTopSize();

		$(window).on('resize', function() {
			initTopSize();
		});
	}

	function eltdfScrollToAnchorSelect() {
		var selectAnchor = $('#eltdf-select-anchor');
		selectAnchor.on('change', function() {
			var selectAnchor = $('option:selected', selectAnchor);

			if(typeof selectAnchor.data('anchor') !== 'undefined') {
				eltdfScrollToPanel(selectAnchor.data('anchor'));
			}
		});
	}

	function eltdfAnchorSelectOnLoad() {
		var currentPanel = window.location.hash;
		if(currentPanel) {
			var selectAnchor = $('#eltdf-select-anchor');
			var currentOption = selectAnchor.find('option[data-anchor="'+currentPanel+'"]').first();

			if(currentOption) {
				currentOption.attr('selected', 'selected');
			}
		}

	}

	function eltdfScrollToPanel(panel) {
		var pageHeader 				= $('.eltdf-page-header');
		var pageHeaderHeight		= pageHeader.height();
		var adminBarHeight			= $('#wpadminbar').height();
		var pageTitle				= $('.eltdf-page-title');
		var pageTitleHeight			= pageTitle.outerHeight();
		console.log(pageTitleHeight);

		var panelTopPosition = $(panel).offset().top - adminBarHeight - pageHeaderHeight - pageTitleHeight;

		$('html, body').animate({
			scrollTop: panelTopPosition
		}, 1000);

		return false;
	}

	function totop_button(a) {
		"use strict";

		var b = $("#back_to_top");
		b.removeClass("off on");
		if (a === "on") { b.addClass("on"); } else { b.addClass("off"); }
	}

	function backButtonShowHide(){
		"use strict";

		$(window).scroll(function () {
			var b = $(this).scrollTop();
			var c = $(this).height();
			var d;
			if (b > 0) { d = b + c / 2; } else { d = 1; }
			if (d < 1e3) { totop_button("off"); } else { totop_button("on"); }
		});
	}

	function backToTop(){
		"use strict";

		$(document).on('click','#back_to_top',function(){
			$('html, body').animate({
				scrollTop: $('html').offset().top}, 1000);
			return false;
		});
	}


	function eltdChangedInput () {
		$('.eltdf-tabs-content').on('change keyup keydown', 'input:not([type="submit"]), textarea, select', function (e) {
			$('.eltdf-input-change').addClass('yes');
		});
		$('.field.switch label:not(.selected)').click( function() {
			$('.eltdf-input-change').addClass('yes');
		});
		$(window).on('beforeunload', function () {
			if ($('.eltdf-input-change.yes').length) {
				return 'You haven\'t saved your changes.';
			}
		});
		$('#anchornav input').click(function() {
			if ($('.eltdf-input-change.yes').length) {
				$('.eltdf-input-change.yes').removeClass('yes');
			}
			$('.eltdf-changes-saved').addClass('yes');
			setTimeout(function(){$('.eltdf-changes-saved').removeClass('yes');}, 3000);
		});
	}

	function eltdCheckVisibilityOfAnchorButtons () {

		$('.eltdf-page-form > div:hidden').each( function() {
			var $panelID =  $(this).attr('id');
			$('#anchornav a').each ( function() {
				if ($(this).attr('href') == '#'+$panelID) {
					$(this).parent().hide();//hide <li>s
				}
			});
		})

	}

	function eltdfCheckVisibilityOfAnchorOptions() {
		$('.eltdf-page-form > div:hidden').each( function() {
			var $panelID =  $(this).attr('id');
			$('#eltdf-select-anchor option').each ( function() {
				if ($(this).data('anchor') == '#'+$panelID) {
					$(this).hide();//hide <li>s
				}
			});
		})
	}

	function eltdfGetArrayOfHiddenElements(changedElement) {
		var hidden_elements_string = changedElement.data('hide');
		hidden_elements_array = [];
		if(typeof hidden_elements_string !== 'undefined' && hidden_elements_string.indexOf(",") >= 0) {
			var hidden_elements_array = hidden_elements_string.split(',');
		} else {
			var hidden_elements_array = new Array(hidden_elements_string);
		}

		return hidden_elements_array;
	}

	function eltdfGetArrayOfShownElements(changedElement) {
		//check for links to show
		var shown_elements_string = changedElement.data('show');
		shown_elements_array = [];
		if(typeof shown_elements_string !== 'undefined' && shown_elements_string.indexOf(",") >= 0) {
			var shown_elements_array = shown_elements_string.split(',');
		} else {
			var shown_elements_array = new Array(shown_elements_string);
		}

		return shown_elements_array;
	}

	function eltdCheckAnchorsOnDependencyChange(){
		$(document).on('click','.cb-enable.dependence, .cb-disable.dependence',function(){
			var hidden_elements_array = eltdfGetArrayOfHiddenElements($(this));
			var shown_elements_array  = eltdfGetArrayOfShownElements($(this));

			//show all buttons, but hide unnecessary ones
			$.each(hidden_elements_array, function(index, value){
				$('#anchornav a').each ( function() {

					if ($(this).attr('href') == value) {
						$(this).parent().hide();//hide <li>s
					}
				});
			});
			$.each(shown_elements_array, function(index, value){
				$('#anchornav a').each ( function() {
					if ($(this).attr('href') == value) {
						$(this).parent().show();//show <li>s
					}
				});
			});
		});
	}

	function eltdfCheckOptionAnchorsOnDependencyChange() {
		$(document).on('click','.cb-enable.dependence, .cb-disable.dependence',function(){
			var hidden_elements_array = eltdfGetArrayOfHiddenElements($(this));
			var shown_elements_array  = eltdfGetArrayOfShownElements($(this));

			//show all buttons, but hide unnecessary ones
			$.each(hidden_elements_array, function(index, value){
				$('#eltdf-select-anchor option').each ( function() {

					if ($(this).data('anchor') == value) {
						$(this).hide();//hide option
					}
				});
			});
			$.each(shown_elements_array, function(index, value){
				$('#eltdf-select-anchor option').each ( function() {
					if ($(this).data('anchor') == value) {
						$(this).show();//show option
					}
				});
			});

			$('#eltdf-select-anchor').selectpicker('refresh');
		});
	}

	function checkBottomPaddingOfFormWrapDiv(){
		//check bottom padding of form wrap div, since bottom holder is changing its height because of the info messages
		setTimeout(function(){
			$('.eltdf-page-form').css('padding-bottom', $('.form-button-section').height());
		},350);
	}




	function eltdfInitSelectChange() {
		$('select.dependence').on('change', function (e) {
			var optionSelected = $("option:selected", this);
			var valueSelected = this.value.replace(/ /g, '');
			$($(this).data('hide-'+valueSelected)).fadeOut();
			$($(this).data('show-'+valueSelected)).fadeIn();
		});
	}

	function eltdfInitSwitch() {
		$(".cb-enable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', true);
			$('.checkboxhidden_yesno',parent).val("yes");
			$('.checkboxhidden_onoff',parent).val("on");
			$('.checkboxhidden_portfoliofollow',parent).val("portfolio_single_follow");
			$('.checkboxhidden_zeroone',parent).val("1");
			$('.checkboxhidden_imagevideo',parent).val("image");
			$('.checkboxhidden_yesempty',parent).val("yes");
			$('.checkboxhidden_flagpost',parent).val("post");
			$('.checkboxhidden_flagpage',parent).val("page");
			$('.checkboxhidden_flagmedia',parent).val("attachment");
			$('.checkboxhidden_flagportfolio',parent).val("portfolio_page");
			$('.checkboxhidden_flagproduct',parent).val("product");
		});
		$(".cb-disable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', false);
			$('.checkboxhidden_yesno',parent).val("no");
			$('.checkboxhidden_onoff',parent).val("off");
			$('.checkboxhidden_portfoliofollow',parent).val("portfolio_single_no_follow");
			$('.checkboxhidden_zeroone',parent).val("0");
			$('.checkboxhidden_imagevideo',parent).val("video");
			$('.checkboxhidden_yesempty',parent).val("");
			$('.checkboxhidden_flagpost',parent).val("");
			$('.checkboxhidden_flagpage',parent).val("");
			$('.checkboxhidden_flagmedia',parent).val("");
			$('.checkboxhidden_flagportfolio',parent).val("");
			$('.checkboxhidden_flagproduct',parent).val("");
		});
		$(".cb-enable.dependence").click(function(){
			$($(this).data('hide')).fadeOut();
			$($(this).data('show')).fadeIn();
		});
		$(".cb-disable.dependence").click(function(){
			$($(this).data('hide')).fadeOut();
			$($(this).data('show')).fadeIn();
		});
	}

	function eltdfInitTooltips() {
		$('.eltdf-tooltip').tooltip();
	}

	function eltdfInitColorpicker() {
		$('.eltdf-page .my-color-field').wpColorPicker({
			change:    function( event, ui ) {
				$('.eltdf-input-change').addClass('yes');
			}
		});
	}

	function eltdfChangeNotification(state) {
		if(state == 'hide') {

		}
	}

	/**
	 * Function that initializes
	 */
	function eltdfInitRangeSlider() {
		if($('.eltdf-slider-range').length) {

			$('.eltdf-slider-range').each(function() {
				var Link = $.noUiSlider.Link;

				var start       = 0;            //starting position of slider
				var min         = 0;            //minimal value
				var max         = 100;          //maximal value of slider
				var step        = 1;            //number of steps to snap to
				var orientation = 'horizontal';   //orientation. Could be vertical or horizontal
				var prefix      = '';           //prefix to the serialized value that is written field
				var postfix     = '';           //postfix to the serialized value that is written to field
				var thousand    = '';           //separator for thousand
				var decimals    = 2;            //number of decimals
				var mark        = '.';          //decimal separator

				//is data-start attribute set for current instance?
				if($(this).data('start') != null && $(this).data('start') !== "" && $(this).data('start') != "0.00") {
					start = $(this).data('start');
					if (start == "1.00") start = 1;
					if(parseInt(start) == start){
						start = parseInt(start);
					}
				}

				//is data-min attribute set for current instance?
				if($(this).data('min') != null && $(this).data('min') !== "") {
					min = $(this).data('min');
				}

				//is data-max attribute set for current instance?
				if($(this).data('max') != null && $(this).data('max') !== "") {
					max = $(this).data('max');
				}

				//is data-step attribute set for current instance?
				if($(this).data('step') != null && $(this).data('step') !== "") {
					step = $(this).data('step');
				}

				//is data-orientation attribute set for current instance?
				if($(this).data('orientation') != null && $(this).data('orientation') !== "") {
					//define available orientations
					var availableOrientations = ['horizontal', 'vertical'];

					//is data-orientation value in array of available orientations?
					if(availableOrientations.indexOf($(this).data('orientation'))) {
						orientation = $(this).data('orientation');
					}
				}

				//is data-prefix attribute set for current instance?
				if($(this).data('prefix') != null && $(this).data('prefix') !== "") {
					prefix = $(this).data('prefix');
				}

				//is data-postfix attribute set for current instance?
				if($(this).data('postfix') != null && $(this).data('postfix') !== "") {
					postfix = $(this).data('postfix');
				}

				//is data-thousand attribute set for current instance?
				if($(this).data('thousand') != null && $(this).data('thousand') !== "") {
					thousand = $(this).data('thousand');
				}

				//is data-decimals attribute set for current instance?
				if($(this).data('decimals') != null && $(this).data('decimals') !== "") {
					decimals = $(this).data('decimals');
				}

				//is data-mark attribute set for current instance?
				if($(this).data('mark') != null && $(this).data('mark') !== "") {
					mark = $(this).data('mark');
				}

				$(this).noUiSlider({
					start: start,
					step: step,
					orientation: orientation,
					range: {
						'min': min,
						'max': max
					},
					serialization: {
						lower: [
							new Link({
								target: $(this).prev('.eltdf-slider-range-value')
							})
						],
						format: {
							// Set formatting
							thousand: thousand,
							postfix: postfix,
							prefix: prefix,
							decimals: decimals,
							mark: mark
						}
					}
				}).on({
					change: function(){
						$('.eltdf-input-change').addClass('yes');
					}
				});
			});
		}
	}

	function eltdfInitMediaUploader() {
		if($('.eltdf-media-uploader').length) {
			$('.eltdf-media-uploader').each(function() {
				var fileFrame;
				var uploadUrl;
				var uploadHeight;
				var uploadWidth;
				var uploadImageHolder;
				var attachment;
				var removeButton;

				//set variables values
				uploadUrl           = $(this).find('.eltdf-media-upload-url');
				uploadHeight        = $(this).find('.eltdf-media-upload-height');
				uploadWidth        = $(this).find('.eltdf-media-upload-width');
				uploadImageHolder   = $(this).find('.eltdf-media-image-holder');
				removeButton        = $(this).find('.eltdf-media-remove-btn');

				if (uploadImageHolder.find('img').attr('src') != "") {
					removeButton.show();
					eltdfInitMediaRemoveBtn(removeButton);
				}

				$(this).on('click', '.eltdf-media-upload-btn', function() {
					//if the media frame already exists, reopen it.
					if (fileFrame) {
						fileFrame.open();
						return;
					}

					//create the media frame
					fileFrame = wp.media.frames.fileFrame = wp.media({
						title: $(this).data('frame-title'),
						button: {
							text: $(this).data('frame-button-text')
						},
						multiple: false
					});

					//when an image is selected, run a callback
					fileFrame.on( 'select', function() {
						attachment = fileFrame.state().get('selection').first().toJSON();
						removeButton.show();
						eltdfInitMediaRemoveBtn(removeButton);
						//write to url field and img tag
						if(attachment.hasOwnProperty('url') && attachment.hasOwnProperty('sizes')) {
							uploadUrl.val(attachment.url);
							if (attachment.sizes.thumbnail)
								uploadImageHolder.find('img').attr('src', attachment.sizes.thumbnail.url);
							else
								uploadImageHolder.find('img').attr('src', attachment.url);
							uploadImageHolder.show();
						} else if (attachment.hasOwnProperty('url')) {
							uploadUrl.val(attachment.url);
							uploadImageHolder.find('img').attr('src', attachment.url);
							uploadImageHolder.show();
						}

						//write to hidden meta fields
						if(attachment.hasOwnProperty('height')) {
							uploadHeight.val(attachment.height);
						}

						if(attachment.hasOwnProperty('width')) {
							uploadWidth.val(attachment.width);
						}
						$('.eltdf-input-change').addClass('yes');
					});

					//open media frame
					fileFrame.open();
				});
			});
		}

		function eltdfInitMediaRemoveBtn(btn) {
			btn.on('click', function() {
				//remove image src and hide it's holder
				btn.siblings('.eltdf-media-image-holder').hide();
				btn.siblings('.eltdf-media-image-holder').find('img').attr('src', '');

				//reset meta fields
				btn.siblings('.eltdf-media-meta-fields').find('input[type=hidden]').each(function(e) {
					$(this).val('');
				});

				btn.hide();
			});
		}
	}

	function eltdfInitGalleryUploader() {

		var $eltdf_upload_button = jQuery('.eltdf-gallery-upload-btn');

		var $eltdf_clear_button = jQuery('.eltdf-gallery-clear-btn');

		wp.media.customlibEditGallery1 = {

			frame: function() {

				if ( this._frame )
					return this._frame;

				var selection = this.select();

				this._frame = wp.media({
					id: 'eltd_portfolio-image-gallery',
					frame: 'post',
					state: 'gallery-edit',
					title: wp.media.view.l10n.editGalleryTitle,
					editing: true,
					multiple: true,
					selection: selection
				});

				this._frame.on('update', function() {

					var controller = wp.media.customlibEditGallery1._frame.states.get('gallery-edit');
					var library = controller.get('library');
					// Need to get all the attachment ids for gallery
					var ids = library.pluck('id');

					$input_gallery_items.val(ids);

					jQuery.ajax({
						type: "post",
						url: ajaxurl,
						data: "action=eltd_gallery_upload_get_images&ids=" + ids,
						success: function(data) {

							$thumbs_wrap.empty().html(data);

						}
					});

				});

				return this._frame;
			},

			init: function() {

				$eltdf_upload_button.click(function(event) {

					$thumbs_wrap = $(this).parent().prev().prev();
					$input_gallery_items = $thumbs_wrap.next();

					event.preventDefault();
					wp.media.customlibEditGallery1.frame().open();

				});

				$eltdf_clear_button.click(function(event) {

					$thumbs_wrap = $eltdf_upload_button.parent().prev().prev();
					$input_gallery_items = $thumbs_wrap.next();

					event.preventDefault();
					$thumbs_wrap.empty();
					$input_gallery_items.val("");
				});
			},

			// Gets initial gallery-edit images. Function modified from wp.media.gallery.edit
			// in wp-includes/js/media-editor.js.source.html
			select: function() {

				var shortcode = wp.shortcode.next('gallery', '[gallery ids="' + $input_gallery_items.val() + '"]'),
					defaultPostId = wp.media.gallery.defaults.id,
					attachments, selection;

				// Bail if we didn't match the shortcode or all of the content.
				if (!shortcode)
					return;

				// Ignore the rest of the match object.
				shortcode = shortcode.shortcode;

				if (_.isUndefined(shortcode.get('id')) && !_.isUndefined(defaultPostId))
					shortcode.set('id', defaultPostId);

				attachments = wp.media.gallery.attachments(shortcode);
				selection = new wp.media.model.Selection(attachments.models, {
					props: attachments.props.toJSON(),
					multiple: true
				});

				selection.gallery = attachments.gallery;

				// Fetch the query's attachments, and then break ties from the
				// query to allow for sorting.
				selection.more().done(function() {
					// Break ties with the query.
					selection.props.set({
						query: false
					});
					selection.unmirror();
					selection.props.unset('orderby');
				});

				return selection;

			}

		};
		$(wp.media.customlibEditGallery1.init);
	}

	function eltdInitPortfolioItemAcc() {
		//remove portfolio item
		$(document).on('click', '.remove-portfolio-item', function(event) {
			event.preventDefault();
			var $toggleHolder = $(this).parent().parent().parent();
			$toggleHolder.fadeOut(300,function() {
				$(this).remove();

				//after removing portfolio image, set new rel numbers and set new ids/names
				$('.eltdf-portfolio-additional-item').each(function(i){
					$(this).attr('rel',i+1);
					$(this).find('.number').text($(this).attr('rel'));
					eltdfSetIdOnRemoveItem($(this),i+1);
				});
				//hide expand all button if all items are removed
				noPortfolioItemShown();
			});
			return false;
		});

		//hide expand all button if there is no items
		noPortfolioItemShown();
		function noPortfolioItemShown()  {
			if($('.eltdf-portfolio-additional-item').length == 0){
				$('.eltdf-toggle-all-item').hide();
			}
		}

		//expand all additional sidebar items on click on 'expand all' button
		$(document).on('click', '.eltdf-toggle-all-item', function(event) {
			event.preventDefault();
			$('.eltdf-portfolio-additional-item').each(function(i){

				var $toggleContent = $(this).find('.eltdf-portfolio-toggle-content');
				var $this = $(this).find('.toggle-portfolio-item');
				if ($toggleContent.is(':visible')) {
				}
				else {
					$toggleContent.slideToggle();
					$this.html('<i class="fa fa-caret-down"></i>')
				}
			});
			return false;
		});
		//toggle for portfolio additional sidebar items
		$(document).on('click', '.eltdf-portfolio-additional-item .eltdf-portfolio-toggle-holder', function(event) {
			event.preventDefault();

			var $this = $(this);
			var $caret_holder = $this.find('.toggle-portfolio-item');
			$caret_holder.html('<i class="fa fa-caret-up"></i>');
			var $toggleContent = $this.next();
			$toggleContent.slideToggle(function() {
				if ($toggleContent.is(':visible')) {
					$caret_holder.html('<i class="fa fa-caret-up"></i>')
				}
				else {
					$caret_holder.html('<i class="fa fa-caret-down"></i>')
				}
				//hide expand all button function in case of all boxes revealed
				checkExpandAllBtn();
			});
			return false;
		});
		//hide expand all button when it's clicked
		$(document).on('click','.eltdf-toggle-all-item', function(event) {
			event.preventDefault();
			$(this).hide();
		})

		function checkExpandAllBtn() {
			if($('.eltdf-portfolio-additional-item .eltdf-portfolio-toggle-content:hidden').length == 0){
				$('.eltdf-toggle-all-item').hide();
			}else{
				$('.eltdf-toggle-all-item').show();
			}
		}

	}

	function eltdfInitPortfolioItemsBox() {
		var eltd_portfolio_additional_item = $('.eltdf-portfolio-additional-item-holder').clone().html();
		$portfolio_item = '<div class="eltdf-portfolio-additional-item" rel="">'+ eltd_portfolio_additional_item +'</div>';

		$('a.eltdf-add-item').click(function (event) {
			event.preventDefault();
			$(this).parent().before($($portfolio_item).hide().fadeIn(500));
			var portfolio_num = $(this).parent().siblings('.eltdf-portfolio-additional-item').length;
			$(this).parent().siblings('.eltdf-portfolio-additional-item:last').attr('rel',portfolio_num);
			eltdfSetIdOnAddItem($(this).parent(),portfolio_num);
			$(this).parent().prev().find('.number').text(portfolio_num);
		});
	}

	function eltdfSetIdOnAddItem(addButton,portfolio_num){

		addButton.siblings('.eltdf-portfolio-additional-item:last').find('input[type="text"], input[type="hidden"], select, textarea').each(function(){
			var name = $(this).attr('name');
			var new_name= name.replace("_x", "[]");
			var new_id = name.replace("_x", "_"+portfolio_num);
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});
	}

	function eltdfSetIdOnRemoveItem(portfolio,portfolio_num){

		if(portfolio_num == undefined){
			var portfolio_num = portfolio.attr('rel');
		}else{
			var portfolio_num = portfolio_num;
		}

		portfolio.find('input[type="text"], input[type="hidden"], select, textarea').each(function(){
			var name = $(this).attr('name').split('[')[0];
			var new_name = name+"[]";
			var new_id = name+"_"+portfolio_num;
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});

	}



	function eltdInitPortfolioMediaAcc() {
		//remove portfolio media
		$(document).on('click', '.remove-portfolio-media', function(event) {
			event.preventDefault();
			var $toggleHolder = $(this).parent().parent().parent();
			$toggleHolder.fadeOut(300,function() {
				$(this).remove();

				//after removing portfolio image, set new rel numbers and set new ids/names
				$('.eltdf-portfolio-media').each(function(i){
					$(this).attr('rel',i+1);
					$(this).find('.number').text($(this).attr('rel'));
					eltdfSetIdOnRemoveMedia($(this),i+1);
				});
				//hide expand all button if all medias are removed
				noPortfolioMedia()
			});  return false;
		});

		//hide 'expand all' button if there is no media
		noPortfolioMedia();
		function noPortfolioMedia() {
			if($('.eltdf-portfolio-media').length == 0){
				$('.eltdf-toggle-all-media').hide();
			}
		}

		//expand all portfolio medias (video and images) onClick on 'expand all' button
		$(document).on('click','.eltdf-toggle-all-media', function(event) {
			event.preventDefault();
			$('.eltdf-portfolio-media').each(function(i){

				var $toggleContent = $(this).find('.eltdf-portfolio-toggle-content');
				var $this = $(this).find('.toggle-portfolio-media');
				if ($toggleContent.is(':visible')) {
				}
				else {
					$toggleContent.slideToggle();
					$this.html('<i class="fa fa-caret-down"></i>')
				}

			});        return false;
		});
		//toggle for portfolio media (images or videos)
		$(document).on('click', '.eltdf-portfolio-media .eltdf-portfolio-toggle-holder', function(event) {
			event.preventDefault();
			var $this = $(this);
			var $caret_holder = $this.find('.toggle-portfolio-media');
			$caret_holder.html('<i class="fa fa-caret-up"></i>');
			var $toggleContent = $(this).next();
			$toggleContent.slideToggle(function() {
				if ($toggleContent.is(':visible')) {
					$caret_holder.html('<i class="fa fa-caret-up"></i>')
				}
				else {
					$caret_holder.html('<i class="fa fa-caret-down"></i>')
				}
				//hide expand all button function in case of all boxes revealed
				checkExpandAllMediaBtn();
			});
			return false;
		});
		//hide expand all button when it's clicked
		$(document).on('click','.eltdf-toggle-all-media', function(event) {
			event.preventDefault();
			$(this).hide();
		});
		function checkExpandAllMediaBtn() {
			if($('.eltdf-portfolio-media .eltdf-portfolio-toggle-content:hidden').length == 0){
				$('.eltdf-toggle-all-media').hide();
			}else{
				$('.eltdf-toggle-all-media').show();
			}
		}
	}



	function eltdfInitPortfolioImagesVideosBox() {
		var eltdf_portfolio_images = $('.eltdf-hidden-portfolio-images').clone().html();
		$portfolio_image = '<div class="eltdf-portfolio-images eltdf-portfolio-media" rel="">'+ eltdf_portfolio_images +'</div>';
		var eltdf_portfolio_videos = $('.eltdf-hidden-portfolio-videos').clone().html();

		$portfolio_videos = '<div class="eltdf-portfolio-videos eltdf-portfolio-media" rel="">'+ eltdf_portfolio_videos +'</div>';
		$('a.eltdf-add-image').click(function (e) {
			e.preventDefault();
			$(this).parent().before($($portfolio_image).hide().fadeIn(500));
			var portfolio_num = $(this).parent().siblings('.eltdf-portfolio-media').length;
			$(this).parent().siblings('.eltdf-portfolio-media:last').attr('rel',portfolio_num);
			eltdfInitMediaUploaderAdded($(this).parent());
			eltdfSetIdOnAddMedia($(this).parent(),portfolio_num);
			$(this).parent().prev().find('.number').text(portfolio_num);
		});

		$('a.eltdf-add-video').click(function (e) {
			e.preventDefault();
			$(this).parent().before($($portfolio_videos).hide().fadeIn(500));
			var portfolio_num = $(this).parent().siblings('.eltdf-portfolio-media').length;
			$(this).parent().siblings('.eltdf-portfolio-media:last').attr('rel',portfolio_num);
			eltdfInitMediaUploaderAdded($(this).parent());
			eltdfSetIdOnAddMedia($(this).parent(),portfolio_num);
			$(this).parent().prev().find('.number').text(portfolio_num);
		});

		$(document).on('click', '.eltdf-remove-last-row-media', function(event) {
			event.preventDefault();
			$(this).parent().prev().fadeOut(300,function() {
				$(this).remove();

				//after removing portfolio image, set new rel numbers and set new ids/names
				$('.eltdf-portfolio-media').each(function(i){
					$(this).attr('rel',i+1);
					eltdfSetIdOnRemoveMedia($(this),i+1);
				});
			});

		});
		eltdfShowHidePorfolioImageVideoType();
		$(document).on('change', 'select.eltdf-portfoliovideotype', function(e) {
			eltdfShowHidePorfolioImageVideoType();
		});
	}

	function eltdfSetIdOnAddMedia(addButton,portfolio_num){

		addButton.siblings('.eltdf-portfolio-media:last').find('input[type="text"], input[type="hidden"], select, textarea').each(function(){
			var name = $(this).attr('name');
			var new_name= name.replace("_x", "[]");
			var new_id = name.replace("_x", "_"+portfolio_num);
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});

		eltdfShowHidePorfolioImageVideoType();
	}

	function eltdfSetIdOnRemoveMedia(portfolio,portfolio_num){

		if(portfolio_num == undefined){
			var portfolio_num = portfolio.attr('rel');
		}else{
			var portfolio_num = portfolio_num;
		}

		portfolio.find('input[type="text"], input[type="hidden"], select, textarea').each(function(){
			var name = $(this).attr('name').split('[')[0];
			var new_name = name+"[]";
			var new_id = name+"_"+portfolio_num;
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});

	}


	function eltdfSetIdOnAddPortfolio(addButton,portfolio_num){

		addButton.siblings('.eltdf_portfolio_image:last').find('input[type="text"], input[type="hidden"], select').each(function(){
			var name = $(this).attr('name');
			var new_name= name.replace("_x", "[]");
			var new_id = name.replace("_x", "_"+portfolio_num);
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});

		eltdfShowHidePorfolioImageVideoType();
	}

	function eltdfSetIdOnRemovePortfolio(portfolio,portfolio_num){

		if(portfolio_num == undefined){
			var portfolio_num = portfolio.attr('rel');
		}else{
			var portfolio_num = portfolio_num;
		}

		portfolio.find('input[type="text"], select').each(function(){
			var name = $(this).attr('name').split('[')[0];
			var new_name = name+"[]";
			var new_id = name+"_"+portfolio_num;
			$(this).attr('name',new_name);
			$(this).attr('id',new_id);

		});

	}

	function eltdfShowHidePorfolioImageVideoType(){

		$('.eltdf-portfoliovideotype').each(function(i){

			var $selected = $(this).val();

			if($selected == "self"){
				$(this).parent().parent().parent().find('.eltdf-video-id-holder').hide();
				$(this).parent().parent().parent().parent().find('.eltdf-media-uploader').show();
				$(this).parent().parent().parent().find('.eltdf-video-self-hosted-path-holder').show();
			}else{
				$(this).parent().parent().parent().find('.eltdf-video-id-holder').show();
				$(this).parent().parent().parent().parent().find('.eltdf-media-uploader').hide();
				$(this).parent().parent().parent().find('.eltdf-video-self-hosted-path-holder').hide();
			}
		});
	}

	function eltdfInitMediaUploaderAdded(addButton) {

		addButton.siblings('.eltdf-portfolio-media:last').find('.eltdf-media-uploader').each(function(){
			var fileFrame;
			var uploadUrl;
			var uploadHeight;
			var uploadWidth;
			var uploadImageHolder;
			var attachment;
			var removeButton;

			//set variables values
			uploadUrl           = $(this).find('.eltdf-media-upload-url');
			uploadHeight        = $(this).find('.eltdf-media-upload-height');
			uploadWidth        = $(this).find('.eltdf-media-upload-width');
			uploadImageHolder   = $(this).find('.eltdf-media-image-holder');
			removeButton        = $(this).find('.eltdf-media-remove-btn');

			if (uploadImageHolder.find('img').attr('src') != "") {
				removeButton.show();
				eltdfInitMediaRemoveBtn(removeButton);
			}

			$(this).on('click', '.eltdf-media-upload-btn', function() {
				//if the media frame already exists, reopen it.
				if (fileFrame) {
					fileFrame.open();
					return;
				}

				//create the media frame
				fileFrame = wp.media.frames.fileFrame = wp.media({
					title: $(this).data('frame-title'),
					button: {
						text: $(this).data('frame-button-text')
					},
					multiple: false
				});

				//when an image is selected, run a callback
				fileFrame.on( 'select', function() {
					attachment = fileFrame.state().get('selection').first().toJSON();
					removeButton.show();
					eltdfInitMediaRemoveBtn(removeButton);
					//write to url field and img tag
					if(attachment.hasOwnProperty('url') && attachment.hasOwnProperty('sizes')) {
						uploadUrl.val(attachment.url);
						if (attachment.sizes.thumbnail)
							uploadImageHolder.find('img').attr('src', attachment.sizes.thumbnail.url);
						else
							uploadImageHolder.find('img').attr('src', attachment.url);
						uploadImageHolder.show();
					} else if (attachment.hasOwnProperty('url')) {
						uploadUrl.val(attachment.url);
						uploadImageHolder.find('img').attr('src', attachment.url);
						uploadImageHolder.show();
					}

					//write to hidden meta fields
					if(attachment.hasOwnProperty('height')) {
						uploadHeight.val(attachment.height);
					}

					if(attachment.hasOwnProperty('width')) {
						uploadWidth.val(attachment.width);
					}
					$('.eltdf-input-change').addClass('yes');
				});

				//open media frame
				fileFrame.open();
			});
		});

		function eltdfInitMediaRemoveBtn(btn) {
			btn.on('click', function() {
				//remove image src and hide it's holder
				btn.siblings('.eltdf-media-image-holder').hide();
				btn.siblings('.eltdf-media-image-holder').find('img').attr('src', '');

				//reset meta fields
				btn.siblings('.eltdf-media-meta-fields').find('input[type=hidden]').each(function(e) {
					$(this).val('');
				});

				btn.hide();
			});
		}
	}

	function eltdfInitAjaxForm() {
		$('#eltd_top_save_button').click( function() {
			$('.eltd_ajax_form').submit();
			if ($('.eltdf-input-change.yes').length) {
				$('.eltdf-input-change.yes').removeClass('yes');
			}
			$('.eltdf-changes-saved').addClass('yes');
			setTimeout(function(){$('.eltdf-changes-saved').removeClass('yes');}, 3000);
			return false;
		});
		$(document).delegate(".eltd_ajax_form", "submit", function (a) {
			var b = $(this);
			var c = {
				action: "eltdf_save_options"
			};
			jQuery.ajax({
				url: ajaxurl,
				cache: !1,
				type: "POST",
				data: jQuery.param(c, !0) + "&" + b.serialize()
//            ,
//            success: function(data, textStatus, XMLHttpRequest){
//                alert(data);
//            }
			}), a.preventDefault(), a.stopPropagation()
		})
	}

	function eltdfInitDatePicker() {
		$( ".eltdf-input.datepicker" ).datepicker( { dateFormat: "MM dd, yy" });
	}
    function eltdfInitSelectPicker() {
        $(".eltdf-selectpicker").selectpicker({
            style: 'btn-info',
            size: 10
        });
    }

    function eltdShowHidePostFormats(){


        $('input[name="post_format"]').each(function(){
            $('#eltdf-meta-box-'+ $(this).attr("id")).hide();
        });

        var $selected = $("input[name='post_format']:checked").attr("id");

        $('#eltdf-meta-box-'+ $selected).fadeIn();
        $("input[name='post_format']").change(function() {
            eltdShowHidePostFormats();
        });

    }

	function eltdRemoveVCDeprecatedClass() {
		$('.wpb-layout-element-button').each( function() {
			$(this).removeClass('vc_element-deprecated');
		})
	}

})(jQuery);
