/**
 * Theme Customizer related js
 */

jQuery(document).ready(function() {

   jQuery('#customize-info .preview-notice').append(
		'<a class="themegrill-pro-info" href="http://themegrill.com/themes/ample-pro/" target="_blank">{pro}</a>'
		.replace('{pro}',ample_customizer_obj.pro));

});