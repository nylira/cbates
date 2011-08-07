jQuery(document).ready(function() {
	// call rel="ajax" links with ajax
	jQuery('a[rel="ajax"]').click(function(eh) {
		eh.preventDefault();

		jQuery.get(jQuery(this).attr('href'));
		jQuery(this).parents('div.updated, div.error').fadeOut('slow');
	});
	
	// preview update trigger
	updatePreview = function() {
		jQuery('#previewImg_text').show();

		jQuery('#previewImg_text').attr('src', location.href + '&watermarkPreview&' + jQuery('#watermark_text input, #watermark_text select').serialize());
	}
	jQuery('#watermark_text input:text').keyup(updatePreview);
	jQuery('#watermark_text select').change(updatePreview);
	
	// show color selector
	jQuery('.colorSelector').show();
	// define color selector events
	jQuery('.colorSelector').ColorPicker({
		color: jQuery('input[name="watermark_text[color]"]').val(),
		onSubmit: function(hsb, hex, rgb, el) {
			jQuery('.colorSelector div').css('background-color', '#' + hex);
			jQuery('input[name="watermark_text[color]"]').val(hex);
			jQuery(el).ColorPickerHide();
			updatePreview();
		}	
	});
	
	updatePreview();
});