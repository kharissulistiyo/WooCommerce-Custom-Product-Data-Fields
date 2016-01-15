(function($){

	"use strict";

	var file_frame;

	if ($('a.wcpdf-remove-image').length > 0){
		$(document).on('click', 'a.wcpdf-remove-image', function(e) {

			e.preventDefault();

			$(this).parent().parent().children('.wcpdf_image_id').val('');
			$(this).parent().parent().children('.wcpdf_image_url').val('');
			$(this).parent().children('img').remove();

			if($('.gal-item').length > 0){
				$(this).next('input').val('').remove();
			}

			$(this).remove();

		});
	}

	if ($('a.wcpdf-uppload-image').length > 0){
		$(document).on('click', 'a.wcpdf-uppload-image', function(e) {

			e.preventDefault();

			var $fieldID 					= $(this).parent().children('.wcpdf_image_id' );
			var $fieldURL 				= $(this).parent().children( '.wcpdf_image_url' );
			var $preViewWrapper 	= $(this).parent().children('.preview-image-wrapper');
			var $savedImage 		  = $(this).parent().children('.preview-image-wrapper').find('.iumb_saved_image');

			if (file_frame) file_frame.close();

			file_frame = wp.media.frames.file_frame = wp.media({
				title: $(this).data('uploader-title'),
				library: {
					type: 'image'
				},
				button: {
				text: $(this).data('uploader-button-text'),
				},
				multiple: false
			});

			file_frame.on('select', function() {
				var listIndex = $('#image-uploader-meta-box-list li').index($('#image-uploader-meta-box-list li:last')),
					selection = file_frame.state().get('selection');

				selection.map(function(attachment) {

					var attachment = attachment.toJSON();
					var imageURL = attachment.url;
					var imageID  = attachment.id;

					$('.iumb').val(attachment.url);

					if( attachment.url != '' ){

						$savedImage.remove();

						var preview = '<img src="'+imageURL+'" />'+
													'<a href="#" class="remove_image wcpdf-remove-image"><em>Remove</em></a>';

						$($preViewWrapper).html(preview);

						$fieldURL.val(imageURL);
						$fieldID.val(imageID);

					}

				});

			});

			file_frame.open();

		});
	}




	/**
	 * ==========================
	 * Gallery images start
	 * ==========================
	 */

	 if ($('a.wcpdf-uppload-image-gallery').length > 0){
 		$(document).on('click', 'a.wcpdf-uppload-image-gallery', function(e) {

 			e.preventDefault();

 			var $fieldID 					= $(this).parent().children('.wcpdf_image_id' );
 			var $fieldURL 				= $(this).parent().children( '.wcpdf_image_url' );
 			var $preViewWrapper 	= $(this).parent().children('.preview-image-wrapper');
 			var $savedImage 		  = $(this).parent().children('.preview-image-wrapper').find('.iumb_saved_image');

 			if (file_frame) file_frame.close();

 			file_frame = wp.media.frames.file_frame = wp.media({
 				title: $(this).data('uploader-title'),
 				library: {
 					type: 'image'
 				},
 				button: {
 				text: $(this).data('uploader-button-text'),
 				},
 				multiple: true
 			});

 			file_frame.on('select', function() {
 				var listIndex = $('#image-uploader-meta-box-list li').index($('#image-uploader-meta-box-list li:last')),
 					selection = file_frame.state().get('selection');

	 				selection.map(function(attachment) {

	 					var attachment = attachment.toJSON();
	 					var imageURL = attachment.url;
	 					var imageID  = attachment.id;

	 					$('.iumb').val(attachment.url);

	 					if( attachment.url != '' ){

	 						$savedImage.remove();

	 						var preview = '<div class="gal-item">'+
														'<img src="'+imageURL+'" />'+
	 													'<a href="#" class="remove_image wcpdf-remove-image"><em>Remove</em></a>'+
														'<input type="hidden" name="'+$fieldID.attr('data-name')+'[]" value="'+imageID+'" />'+
														'</div>';

	 						$($preViewWrapper).append(preview);

	 						$fieldURL.val(imageURL);
	 						$fieldID.val(imageID);

	 					}

	 				});

 				});

 				file_frame.open();

 			});
 		}


	 /**
	  * ==========================
	  * Gallery images end
		* ==========================
		*/


		// Color Picker

		if($('.wc_cpdf_colorpicker').length > 0){
			$('.wc_cpdf_colorpicker').wpColorPicker();
		}


		// Date picker

		if($('.wc_cpdf_datepicker').length > 0){

			$( '.wc_cpdf_datepicker' ).each( function() {
				$('.wc_cpdf_datepicker').datepicker({
					defaultDate: '',
					dateFormat: 'yy-mm-dd',
					numberOfMonths: 1,
					showButtonPanel: true
				});
			});

		}


})(jQuery);
