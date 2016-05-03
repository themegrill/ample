/* global ample_customizer_obj */

jQuery(document).ready(function() {
	/**
	 * Theme Customizer related js
	 */

	jQuery('#customize-info .preview-notice').append(
		'<a class="themegrill-pro-info" href="http://themegrill.com/themes/ample-pro/" target="_blank">{pro}</a>'
		.replace('{pro}',ample_customizer_obj.pro));

});
